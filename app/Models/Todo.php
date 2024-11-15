<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['name', 'description', 'status', 'category_id'];

    protected $casts = [
        'status' => Status::class
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($todo) {
            if (is_null($todo->status)) {
                $todo->status = Status::PENDING->value;
            }
        });
    }
}
