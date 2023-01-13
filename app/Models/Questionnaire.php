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

    public function organizations()
    {
        return $this->belongsToMany(Organization::class)
            ->withTimestamps()
            ->withPivot(['user_id', 'answers']);
    } 
}
