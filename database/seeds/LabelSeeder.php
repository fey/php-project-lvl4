<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('labels')->insert([
            ['name' => 'Critical'],
            ['name' => 'High'],
            ['name' => 'Medium'],
            ['name' => 'Low'],
        ]);
        DB::table('labels')
            ->whereNull('created_at')
            ->whereNull('updated_at')
            ->update([
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}
