<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

    /*
      @param  $data
      @return $borrowRecord
  */
    public function createUser($data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'roles_name' => $data['roles_name']??'user',
        ]);
    }

    
    /*
      @param  User $user
      @param   $data
      @return $user
  */
    public function updateUser(User $user, $data)
    {
        $user->update([
            'name' => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
            'password' => isset($data['password']) ? Hash::make($data['password']) : $user->password,
            'roles_name' => $data['roles_name'] ??  'default_role',
        ]);

        return $user;
    }
}
