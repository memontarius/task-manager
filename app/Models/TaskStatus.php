<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TaskStatus extends Model
{
    use HasFactory;

    protected $table = 'task_statuses';

    protected $fillable = [
        'name'
    ];

    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'status_id');
    }
}
