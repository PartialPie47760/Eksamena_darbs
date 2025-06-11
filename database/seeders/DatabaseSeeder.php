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
        
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Oskars Maksims',
            'email' => 'oskarmaksim@gmail.com',
            'password' => Hash::make('Artjom2009'),
            'role' => 'admin',
        ]);

        Status::create(['name' => 'Новая']);
        Status::create(['name' => 'В работе']);
        Status::create(['name' => 'Завершена']);

        Priority::create(['name' => 'Низкий']);
        Priority::create(['name' => 'Средний']);
        Priority::create(['name' => 'Высокий']);

        // Создаем несколько тестовых проектов
        $project1 = Project::factory()->create([
            'name' => 'Разработка сайта',
            'description' => 'Создание нового корпоративного сайта.',
            'created_by' => $admin->id, // Кто создал проект
        ]);
        $project2 = Project::factory()->create([
            'name' => 'Маркетинговая кампания',
            'description' => 'Запуск новой рекламной кампании.',
            'created_by' => $admin->id,
        ]);

        // Создаем несколько тестовых задач
        Task::factory()->create([
            'title' => 'Разработать главную страницу',
            'description' => 'Создать макет и сверстать главную страницу.',
            'status_id' => Status::where('name', 'В работе')->first()->id,
            'priority_id' => Priority::where('name', 'Высокий')->first()->id,
            'due_date' => now()->addDays(7),
            'user_id' => $user->id, // Автор задачи
            'assigned_to_user_id' => $user->id, // Назначено этому пользователю
            'project_id' => $project1->id,
        ]);

        Task::factory()->create([
            'title' => 'Написать контент для блога',
            'description' => 'Подготовить 5 статей для блога.',
            'status_id' => Status::where('name', 'Новая')->first()->id,
            'priority_id' => Priority::where('name', 'Средний')->first()->id,
            'due_date' => now()->addDays(14),
            'user_id' => $admin->id,
            'assigned_to_user_id' => $user->id,
            'project_id' => $project2->id,
        ]);

        // Если у вас есть другие сидеры, вызовите их здесь:
        // $this->call(TaskSeeder::class);
        // $this->call(ProjectSeeder::class);
    }
}
