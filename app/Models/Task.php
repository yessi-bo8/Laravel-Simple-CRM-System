<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'name', 'description', 'user_id', 'client_id', 'status', 'priority', 'due_date'];



    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function scopeAccessibleBy($query, $user)
    {
        $isAdmin = $user->roles->contains('name', 'admin');
        $isMod = $user->roles->contains('name', 'moderator');
        $isUser = $user->roles->contains('name', 'user');
        Log::info('$isAdmin value: ' . ($isAdmin ? 'true' : 'false'));
        Log::info('$isMod value: ' . ($isMod ? 'true' : 'false'));
        Log::info('$isUser value: ' . ($isUser ? 'true' : 'false'));
        
        if ($isAdmin || $isMod) {
            return $query;
        }
        
        return $query->where('user_id', $user->id)
                    ->orWhereIn('project_id', function ($query) use ($user) {
                        $query->select('project_id')
                            ->from('tasks')
                            ->whereIn('user_id', [$user->id]);
                    });
    }
}
