<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Address;
use Illuminate\Http\RedirectResponse;

class AddressController extends Controller
{

    public function addAddress()
    {
        return view('add');
    }

    public function viewAddress()
    {
        $addresses = [];
        $addresses = Address::all();
        return view('view', ['addresses' => $addresses]);
    }

    public function saveAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
             'address'  => 'required',
             'long' =>'required',
             'lat' => 'required',
         ]);

        if ($validator->fails()) {
             $errors = $validator->errors()->all();
             return response()->json(['success'=> false, 'errors' => $errors]);
        }
        $address = new Address([
            'address' => $request->get('address'),
            'lat'=> $request->get('lat'),
            'lng'=> $request->get('long')
        ]);
        $address->save();
        return response()->json(['success'=> true]);
    }

    public function deleteAddress(Request $request, $id)
    {
        if(Address::deleteAddress($id)) {
            return redirect('view')->with('success', "successfully deleted!!");
        }
        return redirect('view')->with('error', "Id with $id is not found!!");
    }
}
