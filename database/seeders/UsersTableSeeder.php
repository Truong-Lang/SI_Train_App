<?php

namespace Database\Seeders;

use App\Common\Constant;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datetime = now();
        DB::table('users')->insert([
            'username'          => 'admin',
            'email'             => 'demo@vn.ids.jp',
            'role_id'           => Constant::ROLE['Admin'],
            'email_verified_at' => $datetime,
            'first_name'        => 'ids',
            'last_name'         => 'vn',
            'password'          => Hash::make('admin@123'),
            'active'            => 0,
            'created_at'        => $datetime,
            'created_by'        => 0,
            'updated_at'        => $datetime,
            'updated_by'        => 0
        ]);
    }
}
