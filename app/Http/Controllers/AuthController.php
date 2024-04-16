<?php

namespace App\Http\Controllers;

use App\Http\Resources\userLoginResource;
use App\Http\Resources\userRegisterResource;
use App\Models\Apiuser;
use App\Models\Provider;
use Illuminate\Http\Request;
//use Auth;
use Validator;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Tymon\JWTAuth\Contracts\Providers\Auth as ProvidersAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api',['except'=>['login','register']]);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'nullable',
            'username' => 'nullable',
            'phone' => 'required|unique:providers',
            'password' => 'required|min:3',
            'type' => 'required|in:0,1', // تحديد القيم المسموح بها للنوع (0 أو 1)
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 200,
                'errors' => $validator->errors()
            ], 200);
        }

        // استخراج القيمة المرجعة للـ 'type'
        $type = $request->input('type', 0); // إذا لم يتم تحديد 'type' في الطلب، فسيكون القيمة الافتراضية 0

        $user = Provider::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)],
            ['type' => $type] // تعيين القيمة المرجعة للـ 'type'
        ));
        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'faild!',
            ], 401);
        }
        $userOtp = $this->generateOTP($user->phone);
        $userOtp->send($user->phone);


        return response()->json([
            'status' => 200,
            'message' => 'Provider registered successfully And Otp Has Been Sent On Your Phone ',
            'data' => $user
        ], 200);
    }
    public function generateOTP($phone)
    {
        $provider =  Provider::where('phone', $phone)->first();
        $userOtp = UserOtp::where('provider_id', $provider->id)->latest()->first();
        $now = now();
        if ($userOtp && $now->isBefore($userOtp->expire_at)) {
            return $userOtp;
        }
        return UserOtp::create([
            'provider_id' => $provider->id,
            'otp' => rand(123456, 999999),
            'expire_at' => $now->addMinutes(10)
        ]);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|min:3'
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 200,
                    $validator->errors()
                ],
                200
            );
        }
        if (!$token = Auth::guard('api')->attempt($validator->validated())) {
            return response()->json(
                [
                    'status' => 401,
                    'error' => 'Unauthorized'
                ],
                401
            );
        }
        return $this->createNewToken($token);
    }
    public function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_tybe' => 'bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTl() * 600000,
            'user' => auth()->guard('api')->user(),
            // 'user'=>userLoginResource::make(auth()->user())
        ]);
    }
    public function profile()
    {
        $user = provider::with('services', 'locations')->find(auth()->guard('api')->user()->id);
        return response()->json([
            // 'user' => auth()->guard('api')->user(),
            'user' => $user,
        ]);
    }
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'User logged out',
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $user = Provider::findOrFail($id);

        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'username' => $request->input('username'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'type' => $request->input('type'),
            'location_id' => $request->input('location_id'),
            'service_id' => $request->input('service_id'),
        ]);

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
            $user->save();
        }

        if ($request->hasFile('avater')) {
            $avatar = $request->file('avater');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('avaters'), $avatarName);
            $avatarPath = 'avaters/' . $avatarName;
            $user->avater = $avatarPath;
            $user->save();
        }

        $updatedUser = Provider::findOrFail($id);

        return response()->json([
            'status' => 200,
            'message' => 'Provider updated successfully!',
            'data' => $updatedUser
        ], 200);
    }
}
