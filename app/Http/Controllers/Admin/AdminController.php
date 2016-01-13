<?php

namespace Creuset\Http\Controllers\Admin;

use Creuset\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
