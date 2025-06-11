<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // PRIMARY KEY

            $table->string('title'); 
            $table->text('description')->nullable();

            // Status FK
            $table->foreignId('status_id')
                  ->constrained('statuses')
                  ->onDelete('cascade');

            // Priority FK
            $table->foreignId('priority_id')
                  ->constrained('priorities')
                  ->onDelete('cascade');

            $table->timestamp('due_date')->nullable();

            // Author's tasks FK
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Task's accountable FK
            $table->foreignId('assigned_to_user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            // Projects FK
            $table->foreignId('project_id')
                  ->nullable()
                  ->constrained('projects')
                  ->onDelete('set null');

            $table->timestamps(); // 'created_at' , 'updated_at'
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
