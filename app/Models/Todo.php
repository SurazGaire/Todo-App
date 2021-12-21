<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=[
        'user_id',
        'title',
        'description',
        'status',
        'date',
        'completed_at',

    ];
    protected $casts = [
        'date',
    ];

    const STATUS = [
        "Todo" => "Todo",
        "Doing" => "Doing",
        "Completed" => "Completed",
        "Archived" => "Archived",
    ];
}
