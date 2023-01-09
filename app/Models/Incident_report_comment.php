<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident_report_comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'attachments',
        'comment',
        'user_id',
        'incident_reports_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incident_report()
    {
        return $this->belongsTo(Incident_report::class);
    }
}