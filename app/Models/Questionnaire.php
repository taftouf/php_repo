<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answers',
        'isMultiple'
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function organizations()
    {
        return $this->belongsToMany(Organization::class)
            ->using(PrimaryPivot::class)
            ->withTimestamps()
            ->withPivot(['user_id', 'answers']);
    } 
}
