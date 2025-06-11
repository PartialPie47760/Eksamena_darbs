<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Status;d
use App\Models\Priority;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $project = Project::inRandomOrder()->first() ?? Project::factory()->create();
        $status = Status::inRandomOrder()->first() ?? Status::create(['name' => 'New']);
        $priority = Priority::inRandomOrder()->first() ?? Priority::create(['name' => 'Middle']);

        return [
            'title' => $this->faker->sentence(rand(3, 7)),
            'description' => $this->faker->paragraph(rand(2, 5)),
            'status_id' => $status->id,
            'priority_id' => $priority->id,
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'user_id' => $user->id, 
            'assigned_to_user_id' => $user->id,
            'project_id' => $project->id,
        ];
    }
}
