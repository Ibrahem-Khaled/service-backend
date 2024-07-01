<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'username' => 'string|nullable',
            'type' => 'string|required',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'type' => $request->type,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            $token = Auth::guard('api')->login($user);

            return response()->json(compact('user', 'token'), 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        if (empty($credentials['phone']) || empty($credentials['password'])) {
            return response()->json(['error' => 'missing_credentials'], 400);
        }

        try {
            if (!$token = Auth::guard('api')->attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

        return response()->json(compact('token'));
    }

    public function getProfile()
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['error' => 'user_not_found'], 404);
        }

        return response()->json(compact('user'));
    }

    public function deleteUser()
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['error' => 'user_not_found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'username' => 'string|nullable',
            'phone' => 'string|unique:users,phone,' . $user->id,
            'password' => 'string|min:6|nullable',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            'identity_card' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->hasFile('image')) {
            $userData['image'] = $this->uploadImage($request->file('image'), 'images');
            if ($user->image) {
                $this->deleteImage($user->image);
            }
        }

        if ($request->hasFile('identity_card')) {
            $identityCardPath = $request->file('identity_card')->store('identity_cards', 'public');
            $user->identity_card = $identityCardPath;
        }

        $user->first_name = $request->first_name ?? $user->first_name;
        $user->last_name = $request->last_name ?? $user->last_name;
        $user->username = $request->username ?? $user->username;
        $user->phone = $request->phone ?? $user->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json(compact('user'));
    }

    private function uploadImage($file, $folder)
    {
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($folder), $fileName);
        return $folder . '/' . $fileName;
    }

    private function deleteImage($filePath)
    {
        $fullPath = public_path($filePath);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
