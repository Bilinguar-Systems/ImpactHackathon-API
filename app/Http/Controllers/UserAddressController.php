<?php

namespace App\Http\Controllers;

use App\User;
use App\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public function addUserAddress(Request $request, $user_id) {
        $user = User::where('id', '=', $user_id)->firstOrFail();

        return UserAddress::create(
            [
                'user_id' => $user_id,
                'lot_no' => $request->lot_no,
                'street' => $request->street,
                'barangay' => $request->barangay,
                'municipality' => $request->municipality,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
            ]
        );
    }
}
