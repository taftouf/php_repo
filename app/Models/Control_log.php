<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Control_log extends Model
{
    use HasFactory;

    protected $fillable = [
        'control_submission_id',
        'user_id',
        'type',
        'comment',
        'attachments'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function control()
    {
        return $this->belongsTo(Control::class);
    }
}
