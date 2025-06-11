<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Status;
use App\Models\Priority;
use App\Models\Tag;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->middleware('auth');
        
        $this->authorizeResource(Task::class, 'task');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $tasks = Task::query()
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('assigned_to_user_id', $user->id);
            })
            ->with(['status', 'priority', 'user', 'assignedTo', 'tags', 'project']);

        
        if ($request->has('status_id') && $request->input('status_id') != '') {
            $tasks->where('status_id', $request->input('status_id'));
        }
        if ($request->has('priority_id') && $request->input('priority_id') != '') {
            $tasks->where('priority_id', $request->input('priority_id'));
        }
        if ($request->has('tag_id') && $request->input('tag_id') != '') {
            $tagId = $request->input('tag_id');
            $tasks->whereHas('tags', function ($query) use ($tagId) {
                $query->where('tags.id', $tagId);
            });
        }
        if ($request->has('search') && $request->input('search') != '') {
            $searchTerm = $request->input('search');
            $tasks->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $tasks = $tasks->orderBy('due_date', 'asc')->paginate(10);

        $statuses = Status::all();
        $priorities = Priority::all();
        $tags = Tag::all();
        $users = User::all();
        $projects = Project::all();

        return view('tasks.index', compact('tasks', 'statuses', 'priorities', 'tags', 'users', 'projects'));
    }

    public function create()
    {
        $statuses = Status::all();
        $priorities = Priority::all();
        $tags = Tag::all();
        $users = User::all();
        $projects = Project::all();
        return view('tasks.create', compact('statuses', 'priorities', 'tags', 'users', 'projects'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:statuses,id',
            'priority_id' => 'required|exists:priorities,id',
            'due_date' => 'nullable|date',
            'assigned_to_user_id' => [
                'nullable',
                'exists:users,id',
                function ($attribute, $value, $fail) use ($user, $request) {
                    
                    if ($request->input('assigned_to_user_id') && !$user->can('assignUser')) {
                        $fail('You have no rights to assign tasks to others.');
                    }
                }
            ],
            'project_id' => 'nullable|exists:projects,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        $task = new Task($request->all());
        $task->user_id = Auth::id();
        $task->save();

        if ($request->has('tags')) {
            $task->tags()->sync($request->input('tags'));
        }

        return redirect()->route('tasks.index')->with('success', 'Task succesfully created!');
    }

    public function show(Task $task)
    {
        $task->load('comments.user');
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $statuses = Status::all();
        $priorities = Priority::all();
        $tags = Tag::all();
        $users = User::all();
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'statuses', 'priorities', 'tags', 'users', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        $user = Auth::user();

        $rules = [
            'status_id' => 'required|exists:statuses,id',
        ];

        
        if ($user->id === $task->user_id || $user->isSupremeUser() || $user->isAdmin()) {
            $rules = array_merge($rules, [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'priority_id' => 'required|exists:priorities,id',
                'due_date' => 'nullable|date',
                'assigned_to_user_id' => [
                    'nullable',
                    'exists:users,id',
                    function ($attribute, $value, $fail) use ($user, $request) {
                        if ($request->input('assigned_to_user_id') && !$user->can('assignUser')) {
                            $fail('You have no right to assign tasks to others.');
                        }
                    }
                ],
                'project_id' => 'nullable|exists:projects,id',
                'tags' => 'array',
                'tags.*' => 'exists:tags,id',
            ]);
        }

        $request->validate($rules);

        
        
        $task->update($request->only(array_keys($rules)));

        
        if (($user->id === $task->user_id || $user->isSupremeUser() || $user->isAdmin()) && $request->has('tags')) {
            $task->tags()->sync($request->input('tags'));
        }

        return redirect()->route('tasks.index')->with('success', 'Task succesfully updated!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task succesfully completed!');
    }

    // method for task marking
    public function markAsCompleted(Request $request, Task $task)
    {
        $this->authorize('markAsCompleted', $task);

        $completedStatus = Status::where('name', 'Done')->first();
        if ($completedStatus) {
            $task->status_id = $completedStatus->id;
            $task->save();
            return back()->with('success', 'Task marked as completed!');
        }
        return back()->with('error', 'Could not find task with "Done" status. Make sure it really exists in database.');
    }
}
