<?php

use App\User;
use App\Models\Course\Series;
use App\Models\Security\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if ($this->command->confirm('Anda akan melakukan refresh database, akan menghapus seluruh data?')){
            $this->command->call('migrate:fresh');
            $this->command->warn('Data telah di refresh, mulai dari database kosong');
        }

        $roles = Role::defaultRoles();

        foreach ($roles as $item){
            $role = Role::firstOrCreate(['name'=> $item]);
            $this->createUser($role->name);
        }

        $this->command->info('User & Roles Created');
        $this->call([
            PlanSeeder::class,
        ]);
        $this->command->warn('Data Telah Berhasil Diimport');
    }

    public function createUser($role)
    {
        $user =  User::firstOrCreate([
            'name' => $role,
            'email' => $role.'@'.'webacademy.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole($role);

        if ($role == 'admin') {
            $this->command->info('Here is your admin details to login');
            $this->command->warn($user->email);
            $this->command->warn('Password is "password"');
        }
    }
}
