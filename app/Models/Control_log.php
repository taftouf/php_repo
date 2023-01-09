<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Control_log extends Model
{
    use HasFactory;

    protected $fillable = [
        'control_id',
        'organization_id',
        'assignedTo',
        'assignedTo'
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
