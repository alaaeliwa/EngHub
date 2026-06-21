<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $fillable = ['title', 'date', 'location', 'registered', 'status', 'banner', 'pdf_slides', 'useful_links', 'capacity', 'category', 'description', 'time', 'duration', 'type', 'instructor_name'];

    public function registrations()
    {
        return $this->hasMany(WorkshopRegistration::class);
    }

    public function registeredUsers()
    {
        return $this->belongsToMany(User::class, 'workshop_registrations')->withTimestamps();
    }

    public function isRegistered($userId)
    {
        return $this->registrations()->where('user_id', $userId)->exists();
    }

    public function isFull()
    {
        return $this->registered >= $this->capacity;
    }
}
