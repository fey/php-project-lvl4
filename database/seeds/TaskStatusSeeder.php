<?php

use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_statuses')->insert([
            ['name' => 'New'],
            ['name' => 'Work in progress'],
            ['name' => 'Testing'],
            ['name' => 'Done']
        ]);

        Db::table('task_statuses')->update([
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
