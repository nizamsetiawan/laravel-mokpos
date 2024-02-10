<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required',
            'roles' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if image file is present
        $imageFilename = null;
        if ($request->hasFile('image')) {
            $imageFilename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $imageFilename);
            $data = $request->all();
        }

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $imageFilename,
            'roles' => $request->roles,
            'phone' => $request->phone,

        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User Created',
                'data' => $user,
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User Failed to Save',
            ], 409);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUser(Request $request, string $id)
    {
        $data = $request->validate([
            'roles' => 'sometimes|required',
            'name' => 'sometimes|required|min:3',
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'phone' => 'sometimes|required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            //  'password' => 'sometimes|required|string|min:6',

        ]);

        $user = \App\Models\User::findOrFail($id);

        // Check if image file is present
        $imageFilename = $user->image;

        if ($request->hasFile('image')) {
            $imageFilename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $imageFilename);
        }

        $user->update([
            'name' => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
            'phone' => $data['phone'] ?? $user->phone,
            'image' => $imageFilename ?? $user->image,
            'roles' => $data['roles'] ?? $user->roles,
            // 'password' => Hash::make($data['password'] ?? $user->password),

        ]);

        return response()->json([
            'success' => true,
            'message' => 'User Updated',
            'data' => $user,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return response([
                'message' => ['Email not found'],
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['Password is wrong'],
            ], 404);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    //logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout success',
        ]);
    }


}
