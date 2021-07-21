<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    // General Validation Rules for all Requests type
    public const VALIDATION_RULES = [
        'name'          => ['required', 'string', 'max:255'],
        'email'         => ['required', 'unique:users'],
    ];

    // Handle Image Upload and model relationship
    public function attachImage($file)
    {
        return $this->addMediaFromRequest($file)->toMediaCollection('patients_images');
    }
}
