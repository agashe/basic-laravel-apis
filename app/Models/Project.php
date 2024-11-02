<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Timesheet;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the users for the project.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the time sheets for the project.
     */
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
}
