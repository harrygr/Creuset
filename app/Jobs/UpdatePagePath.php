<?php

namespace App\Jobs;

use App\Page;

class UpdatePagePath extends Job
{
    private $page;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->updatePaths($this->page);
    }

    /**
     * Re-calculate the path of the page and recursively update the paths of children.
     *
     * @return void
     */
    private function updatePaths(Page $page)
    {
        $page->path = $page->getPath();
        $page->save();

        // We'll dispatch updating the child pages to a new job as
        // it isn't important that it happens in real time so we
        // can queue it, improving response time to the user.
        if ($page->fresh()) {
            dispatch(new UpdateChildPagePaths($page));
        }
    }
}
