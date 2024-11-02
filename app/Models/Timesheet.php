<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Project;

class Timesheet extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the project for the time sheet.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user for the time sheet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
