<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'state',
        'city',
        'logo',
        'timezone',
        'currency',
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function incident_reports()
    {
        return $this->hasMany(Incident_report::class);
    }

    public function control_logs()
    {
        return $this->hasMany(Control_log::class);
    }

    public function control_submissions()
    {
        return $this->hasMany(Control_submission::class);
    }

    public function questionnaires()
    {
        return $this->belongsToMany(Questionnaire::class)
            ->using(PrimaryPivot::class)
            ->withTimestamps()
            ->withPivot(['user_id', 'answers']);
    }
}
