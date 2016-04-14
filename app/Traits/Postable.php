<?php

namespace App\Traits;

use Carbon\Carbon;

trait Postable
{
    public function getEditUri()
    {
        return route('admin.'.$this->getTable().'.edit', $this->id);
    }

    /**
     * Parses a date string into a Carbon instance for saving.
     *
     * This shouldn't really need to be done, but Laravel's automatic date
     * mutators expects strings to be in the format Y-m-d H-i-s which is
     * not always the case; such as for 'datetime-local' html5 fields
     *
     * @param mixed $date The date to be parsed
     */
    public function setPublishedAtAttribute($date)
    {
        $this->attributes['published_at'] = is_string($date) ? new Carbon($date) : $date;
    }

    /**
     * Limit the scope of a query to only posts that are published.
     *
     * @param Illuminate\Database\Query\Builder $query
     *
     * @return void
     */
    public function scopePublished($query)
    {
        $query->where('published_at', '<=', new \DateTime())
              ->where('status', 'published');
    }

    /**
     * If the post doesn't have a user ID set we'll return the ID of the logged in user.
     *
     * @param int $userId
     *
     * @return int
     */
    public function getUserIdAttribute($userId)
    {
        return $userId ?: \Auth::user()->id;
    }

    // Relations

    public function author()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    /**
     * Whether the post is not yet persisted.
     *
     * @return bool
     */
    public function isNew()
    {
        return !$this->exists();
    }

    /**
     * Whether the post exists in the database yet.
     *
     * @return bool
     */
    public function exists()
    {
        return $this->id;
    }

    /**
     * The field to use to display the parent name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->title;
    }

    /**
     * Get the post's content as html.
     *
     * @return string
     */
    public function getContentHtml()
    {
        return \Markdown::convertToHtml($this->content);
    }
}
