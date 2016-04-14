<?php

namespace App\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NavViewComposer
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function productLinks(View $view)
    {
        $product = $this->request->route('product');
        $currentUrl = $this->request->url();

        $links = [
            ['url' => route('admin.products.edit', $product), 'text' => 'Edit'],
            ['url' => route('admin.products.images', $product), 'text' => 'Images'],
        ];

        $links = array_map(function ($link) use ($currentUrl) {
            $link['active'] = $currentUrl == $link['url'];

            return $link;
        }, $links);

        $view->with('nav_routes', $links);
    }
}
