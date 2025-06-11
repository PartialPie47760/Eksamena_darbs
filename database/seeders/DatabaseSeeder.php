<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use App\Models\Status;
use App\Models\Priority;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        
        $user = User::factory()->create([
            'name' => 'Oskars Maksims',
            'email' => 'oskarmaksim@gmail.com',
            'password' => Hash::make('LULV'),
            'role' => 'user',
        ]);

        Status::create(['name' => 'New']);
        Status::create(['name' => 'In progress']);
        Status::create(['name' => 'Complete']);

        Priority::create(['name' => 'Low']);
        Priority::create(['name' => 'Middle']);
        Priority::create(['name' => 'High']);

        
        $project1 = Project::factory()->create([
            'name' => 'Web development',
            'description' => 'Neww corporative project development.',
            'created_by' => $admin->id,
        ]);
        $project2 = Project::factory()->create([
            'name' => 'Marketing company',
            'description' => 'New advertisment programm.',
            'created_by' => $admin->id,
        ]);

        Task::factory()->create([
            'title' => 'Develop main page',
            'description' => 'Create demo version of the page.',
            'status_id' => Status::where('name', 'In progress')->first()->id,
            'priority_id' => Priority::where('name', 'High')->first()->id,
            'due_date' => now()->addDays(7),
            'user_id' => $user->id,
            'assigned_to_user_id' => $user->id,
            'project_id' => $project1->id,
        ]);

        Task::factory()->create([
            'title' => 'Blog content writing',
            'description' => 'Prepare 5 stories.',
            'status_id' => Status::where('name', 'New')->first()->id,
            'priority_id' => Priority::where('name', 'Middle')->first()->id,
            'due_date' => now()->addDays(14),
            'user_id' => $admin->id,
            'assigned_to_user_id' => $user->id,
            'project_id' => $project2->id,
        ]);
    }
}
