<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'students', 'courses', 'years', 'subjects'];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function workshops()
    {
        return $this->belongsToMany(Workshop::class);
    }
}
