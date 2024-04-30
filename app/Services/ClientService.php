<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ClientService
{
    /**
     * Handle the upload of a profile picture.
     *
     * @param  \Illuminate\Http\Request  $request The request containing the uploaded file.
     * @return string|null The file path if upload successful, otherwise null.
     * @throws \Exception If upload fails.
     */
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
