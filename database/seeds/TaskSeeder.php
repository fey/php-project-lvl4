<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Task::insert([
            [
                'name' => 'Task 1',
                'description' => 'Task description',
                'status_id' => 1,
                'created_by_id' => 1,
            ],
            [
                'name' => 'Task 2',
                'description' => 'Task description',
                'status_id' => 1,
                'created_by_id' => 1,
            ],
            [
                'name' => 'Task 3',
                'description' => 'Task description',
                'status_id' => 1,
                'created_by_id' => 1,
            ],
            [
                'name' => 'Task 4',
                'description' => 'Task description',
                'status_id' => 1,
                'created_by_id' => 1,
            ],
            [
                'name' => 'Task 5',
                'description' => 'Task description',
                'status_id' => 1,
                'created_by_id' => 1,
            ]
        ]);

        Db::table('tasks')
            ->whereNull('created_at')
            ->whereNull('updated_at')
            ->update([
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
