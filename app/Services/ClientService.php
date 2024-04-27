<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ClientService
{
    public function handleProfilePictureUpload($request)
    {
        if ($request->hasFile('profile_picture')) {
            try {
                // Store the uploaded image
                return $request->file('profile_picture')->store('public/uploads');
            } catch (\Exception $e) {
                Log::error('Error uploading profile picture: ' . $e->getMessage());
                throw new \Exception('Failed to upload profile picture. Please try again.');
            }
        }
        return null;
    }
}
