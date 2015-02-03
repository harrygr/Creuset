<?php namespace Creuset\Http\Controllers\Admin;

use Creuset\Http\Requests;
use Creuset\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminController extends Controller {

	public function __construct(){
		$this->middleware('auth');
	}

	public function dashboard()
	{
		return view('admin.dashboard');
	}

}
