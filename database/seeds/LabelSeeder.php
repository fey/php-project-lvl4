<?php

use Illuminate\Database\Seeder;

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
        DB::table('labels')->update([
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
