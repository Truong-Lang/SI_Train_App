<?php

namespace Database\Seeders;

use App\Common\Constant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datetime = now();
        DB::table('roles')->insert([
            'name'       => 'Admin',
            'active'     => Constant::NUMBER_ONE,
            'created_at' => $datetime,
            'created_by' => Constant::NUMBER_ONE,
            'updated_at' => $datetime,
            'updated_by' => Constant::NUMBER_ONE
        ]);
        DB::table('roles')->insert([
            'name'       => 'User',
            'active'     => Constant::NUMBER_ONE,
            'created_at' => $datetime,
            'created_by' => Constant::NUMBER_ONE,
            'updated_at' => $datetime,
            'updated_by' => Constant::NUMBER_ONE
        ]);
    }
}
