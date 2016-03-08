<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Requests\Address\CreateAddressRequest;
use App\Http\Requests\Address\EditAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use Illuminate\Contracts\Auth\Guard;

class AddressesController extends Controller
{
    /**
     * @var Guard
     */
    private $user;

    /**
     * Create a new addresses controller instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('auth');

        $this->user = $auth->user();
    }

    /**
     * Show the page for creating a new address.
     *
     * @param Address $address
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Address $address)
    {
        return view('addresses.create', compact('address'));
    }

    /**
     * Show a list of the logged in user's addresses.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = $this->user->addresses;

        return view('addresses.index')->with(compact('addresses'));
    }

    /**
     * Save a newly created address in storage.
     *
     * @param CreateAddressRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAddressRequest $request)
    {
        $address = $request->user()->addresses()->create($request->all());

        return redirect()->route('addresses.index')
        ->with(['alert' => 'Address saved', 'alert-class' => 'success']);
    }

    /**
     * Show the page for editing an address.
     *
     * @param Address            $address
     * @param EditAddressRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address, EditAddressRequest $request)
    {
        return view('addresses.edit')->with(compact('address'));
    }

    /**
     * Update an address in storage.
     *
     * @param Address              $address
     * @param UpdateAddressRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Address $address, UpdateAddressRequest $request)
    {
        $address->update($request->all());

        return redirect()->route('addresses.index')
        ->with(['alert' => 'Address Updated', 'alert-class' => 'success']);
    }

    /**
     * Delete an address from storage.
     *
     * @param Address            $address
     * @param EditAddressRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address, EditAddressRequest $request)
    {
        $address->delete();

        return redirect()->route('addresses.index')
        ->with(['alert' => 'Address Deleted', 'alert-class' => 'success']);
    }
}
