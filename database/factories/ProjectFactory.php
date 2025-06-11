<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        return [
            'name' => $this->faker->unique()->company(),
            'description' => $this->faker->paragraph(),
            'created_by' => $user->id,
            
        ];
    }
}
