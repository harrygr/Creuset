<?php

namespace Creuset\Http\Controllers;

use Creuset\Address;
use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests;
use Creuset\Http\Requests\Address\EditAddressRequest;
use Creuset\Http\Requests\Address\UpdateAddressRequest;
use Creuset\Http\Requests\Address\CreateAddressRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    private $user;

    public function __construct(Guard $auth)
    {
        $this->middleware('auth');

        $this->user = $auth->user();
    }

    public function create(Address $address)
    {
        return view('addresses.create', compact('address'));
    }

    public function index()
    {
        $addresses = $this->user->addresses;

        return view('addresses.index')->with(compact('addresses'));
    }

    public function store(CreateAddressRequest $request)
    {
        $address = $request->user()->addresses()->create($request->all());
        return redirect()->route('addresses.index')
        ->with(['alert' => 'Address saved', 'alert-class' => 'success']);
    }

    public function edit(Address $address, EditAddressRequest $request)
    {
        return view('addresses.edit')->with(compact('address'));
    }

    public function update(Address $address, UpdateAddressRequest $request)
    {
        $address->update($request->all());
        return redirect()->route('addresses.index')
        ->with(['alert' => 'Address Updated', 'alert-class' => 'success']);
    }

    public function destroy(Address $address, EditAddressRequest $request)
    {
        $address->delete();
        return redirect()->route('addresses.index')
        ->with(['alert' => 'Address Deleted', 'alert-class' => 'success']);
    }
}
