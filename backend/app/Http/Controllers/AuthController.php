<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use App\Http\Requests\MerchantRegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if(!Auth::attempt($data))
        {
            return $this->error('', 401, 'Credentials does not match');
        }
        
        $user = User::where('email', $data['email'])->first();
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of '. $user->username)->plainTextToken
        ]);
    }

    public function register(MerchantRegisterRequest $request)
    {
        $data = $request->validated();
        
        $user = User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'user_type' => 'customer',
        ]);
        $profile = Profile::create([
            'user_id' => $user->id(),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'photo' => $data['photo']
        ]);

        // $address = Delivery::create([
        //     'user_id' => $user->id(),
        //     'house_number' => $data['house_number'],
        //     'street_name' => $data['street_name'],
        //     'barangay' => $data['barangay'],
        //     'city' => $data['city'],
        //     'is_delivery' => $data['is_delivery']
        // ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of '. $user->username)->plainTextToken,
        ], 
        ['message' => 'Merchant created'],
        201
        );
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            'message' => 'You have successfully logged out and your token has beed deleted!'
        ]);
    }
}
