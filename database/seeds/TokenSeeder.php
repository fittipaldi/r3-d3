<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TokenSeeder extends Seeder
{

    public $timestamps = true;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tokens')->truncate();

        DB::table('tokens')->insert([
            'token' => 'JEDI-EHYJzdWIiOiJkZmRmc2RmZHMiLCJuYW1lIjP0',
            'status' => '1',
            'is_jedi' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('tokens')->insert([
            'token' => 'NO-JEDI-EHYJzdWIiOiJkZmRmc2RmZHMiLCJuYW1lIjP0',
            'status' => '1',
            'is_jedi' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}