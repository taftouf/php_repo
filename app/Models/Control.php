<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category'
    ];

    public function Framework()
    {
        return $this->belongsToMany(Framework::class)
            ->withTimestamps();
    }

    public function control_logs()
    {
        return $this->hasMany(Control_log::class);
    }

    public function control_submissions()
    {
        return $this->hasMany(Control_submission::class);
    }
}
