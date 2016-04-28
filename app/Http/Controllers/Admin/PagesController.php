<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\CreatePageRequest;
use App\Http\Requests\Page\UpdatePageRequest;
use App\Page;

class PagesController extends Controller
{
    use \App\Traits\TrashesModels;

    /**
     * Show a list of pages.
     *
     * @return Response
     */
    public function index()
    {
        $pages = Page::orderBy('lft')->paginate();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page.
     *
     * @param Page $page
     *
     * @return Response
     */
    public function create(Page $page)
    {
        return view('admin.pages.create', compact('page'));
    }

    /**
     * Store a newly created page in storage.
     *
     * @param CreatePostRequest $request
     *
     * @return Response
     */
    public function store(CreatePageRequest $request)
    {
        $page = Page::create($request->all());

        if ($request->get('parent_id')) {
            $page->makeChildOfPage($request->get('parent_id'));
        }

        return redirect()->route('admin.pages.edit', $page)
        ->with([
            'alert'       => 'Page saved',
            'alert-class' => 'success',
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Page $page
     *
     * @return Response
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Post              $post
     * @param UpdatePostRequest $request
     *
     * @return Response
     */
    public function update(Page $page, UpdatePageRequest $request)
    {
        $page->update($request->all());

        if ($request->get('parent_id')) {
            $page->makeChildOfPage($request->get('parent_id'));
        } else {
            $page->makeRoot();
        }

        return redirect()->route('admin.pages.edit', $page)
            ->with([
                'alert'       => 'Page Updated!',
                'alert-class' => 'success',
                ]);
    }

    /**
     * Show the page of trashed pages.
     *
     * @return Response
     */
    public function trash()
    {
        $pages = Page::onlyTrashed()->latest()->paginate(10);
        $title = 'Trash';

        return view('admin.pages.index', compact('pages', 'title'));
    }

    /**
     * Restore the page from soft-deletion.
     *
     * @param Page $post
     *
     * @throws \Exception
     */
    public function restore(Page $page)
    {
        $page->restore();

        return redirect()->route('admin.pages.index')
            ->with([
                'alert'       => 'Page Restored',
                'alert-class' => 'success',
                ]);
    }

    /**
     * Get the URL to the index page for the model.
     *
     * @return string
     */
    protected function getIndexUrl()
    {
        return route('admin.pages.index');
    }
}
