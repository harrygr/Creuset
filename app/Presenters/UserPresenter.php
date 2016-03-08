<?php

namespace App\Presenters;

class UserPresenter extends Presenter
{
    /**
     * Generate the Gravatar URL for a user's avatar.
     *
     * @param int    $size    The pixel dimension of the image
     * @param string $default The default image in case of no gravatar set
     *
     * @return string The image URL
     */
    public function avatar($size = 30, $default = 'identicon')
    {
        $hash = md5($this->model->email);
        $query_string = http_build_query([
            's' => $size,
            'd' => $default,
            ]);

        return "//gravatar.com/avatar/{$hash}/?{$query_string}";
    }
}
