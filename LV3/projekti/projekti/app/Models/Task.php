<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = ["title", "description", "price", "completed_jobs", "start_date", "due_date", "collaborators"];
    protected $policies = [
        'App\Task' =>
            'App\Policies\TaskPolicy',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
