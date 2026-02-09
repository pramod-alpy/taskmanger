<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::create(['name'=>'Student Records','project_id'=>1]);
        Task::create(['name'=>'Teacher Records','project_id'=>1]);
        Task::create(['name'=>'Attendance System','project_id'=>1]);
        Task::create(['name'=>'Library Management','project_id'=>1]);
        Task::create(['name'=>'Inventory Management','project_id'=>2]);
        Task::create(['name'=>'Sales Management','project_id'=>2]);
        Task::create(['name'=>'Purchase Management','project_id'=>2]);
        Task::create(['name'=>'Stock Management','project_id'=>2]);
        Task::create(['name'=>'Supplier Management','project_id'=>2]);
       
    }
}
