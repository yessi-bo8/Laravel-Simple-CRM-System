<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'client_id', 'title', 'description', 'status', 'event_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function scopeAccessibleBy($query, $user)
    {
        $isAdmin = $user->roles->contains('name', 'admin', true);
        if ($isAdmin) {
            return $query->get();
        } else {
            return $query->whereHas('user', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        }
    }
}
