<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'code', 'description', 'instructor', 'status', 'year', 'semester'];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->with('user', 'replies', 'likedByUsers')->orderBy('created_at', 'desc');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
}
