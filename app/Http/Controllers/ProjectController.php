<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // CRUD methods
    public function index() { /* ... */ }
    public function create() { /* ... */ }
    public function store(Request $request) { /* ... */ }
    public function show(Project $project) { /* ... */ }
    public function edit(Project $project) { /* ... */ }
    public function update(Request $request, Project $project) { /* ... */ }
    public function destroy(Project $project) { /* ... */ }
}
