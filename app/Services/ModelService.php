<?php

namespace App\Services;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\ClientNotFoundException;
use App\Exceptions\ProjectNotFoundException;

class ModelService
{
    public function getUserByName($name)
    {
        try {
            return User::where('name', $name)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            throw new UserNotFoundException();
        }
    }

    public function getClientByName($name)
    {
        try {
            return Client::where('name', $name)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            throw new ClientNotFoundException();
        }
    }

    public function getProjectByTitle($title)
    {
        try {
            return Project::where('title', $title)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            throw new ProjectNotFoundException();
        }
    }
}
