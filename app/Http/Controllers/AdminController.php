<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function statistics(Request $request)
    {
        $totalTasks = Task::count();
        
        $completedTasks = Task::whereHas('status', function ($query) {
            $query->where('name', 'Done');
        })->count();
        $totalUsers = User::count();

        $completedTasksLastMonth = Task::whereHas('status', function ($query) {
            $query->where('name', 'Done');
        })->where('updated_at', '>=', now()->subMonth())->count();

        return view('admin.statistics', compact('totalTasks', 'completedTasks', 'totalUsers', 'completedTasksLastMonth'));
    }
}
