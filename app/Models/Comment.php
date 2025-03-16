<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Observers\CommentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([CommentObserver::class])]
class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'task_id',
        'comment',
    ]; 
    
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
