<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident_report extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'report',
        'rootCause',
        'correctiveAction',
        'startTime',
        'endTime',
        'color',
        'organization_id',
        'user_id',
        'nbCaliforniaIndividualsAffected',
        'contactFirstName',
        'contactLastName',
        'contactPhone',
        'contactEmail',
        'contactTitle'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function incident_report_comments()
    {
        return $this->hasMany(Incident_report_comment::class);
    }
}
