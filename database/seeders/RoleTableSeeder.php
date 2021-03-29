<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;
use App\Models\User;
use DB;
use Str;
use Hash;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = new Role();
        $role->name = 'admin';
        $role->description = 'Administrator';
        $role->save();
        $role = new Role();
        $role->name = 'user';
        $role->description = 'User';
        $role->save();
        $role = new Role();
        $role->name = 'manager';
        $role->description = 'Manager';
        $role->save();
        $role = new Role();
        $role->name = 'empleado';
        $role->description = 'Empleado';
        $role->save();

        $user = new User();
        $user->name = 'Luis Heskey';
        $user->email = 'luisbillr@gmail.com';
        $user->password = Hash::make('admin');
        $user->save();
        
        DB::table('role_user')->insert([
            'role_id' => 1,
            'user_id' => 1,
        ]);
    }
}
