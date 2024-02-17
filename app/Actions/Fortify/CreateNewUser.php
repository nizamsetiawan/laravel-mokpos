<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'phone' => ['required'],
            'roles' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ])->validate();

        $filename = null;
        if (isset($input['image'])) {
            $filename = time() . '.' . $input['image']->extension();
            $input['image']->storeAs('public/images', $filename);
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'phone' => $input['phone'],
            'roles' => $input['roles'],
            'image' => $filename,
        ]);
 // Add a success message to the session flash data
 session()->flash('success', 'User created successfully. Please login.');

 // Redirect to the login page
 return redirect('/');
    }
}
