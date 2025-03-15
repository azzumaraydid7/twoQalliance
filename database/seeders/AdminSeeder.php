<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    protected static ?string $password;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_exists = Admin::where('name','admin')->where('email','admin@admin.com')->exists();
        
        if(!$admin_exists) {
            $admin = Admin::create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10)
            ]);

            $admin->assignRole('admin');
        }
    }
}
