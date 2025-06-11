<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $task = Task::inRandomOrder()->first() ?? Task::factory()->create();

        return [
            'content' => $this->faker->paragraph(rand(1, 3)),
            'user_id' => $user->id,
            'task_id' => $task->id,
        ];
    }
}
