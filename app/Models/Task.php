<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status_id',
        'assigned_to_id',
        'created_by_id'
    ];

    protected $casts = [
        'status_id' => 'integer',
        'assigned_to_id' => 'integer',
        'created_by_id' => 'integer'
    ];

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'task_label', 'task_id', 'label_id');
    }

    public function status(): HasOne
    {
        return $this->hasOne(TaskStatus::class, 'id', 'status_id');
    }

    public function performer(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'assigned_to_id');
    }
}
