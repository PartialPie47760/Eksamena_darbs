<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status_id',
        'priority_id',
        'due_date',
        'user_id',             
        'assigned_to_user_id', 
        'project_id',          
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'datetime', 
    ];

    // Relations for Task:

     
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

     
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    
    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

     
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

 
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
