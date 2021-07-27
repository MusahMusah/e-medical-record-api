<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthWorker extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    // Fillable field for mass assignment
    protected $fillable = [
        'name',
        'surname',
        'user_id',
        'age',
        'gender',
        'cadre',
        'department',
        'image',
    ];
    // General Validation Rules for all Requests type
    public const VALIDATION_RULES = [
        'name'          => ['required', 'string', 'max:255'],
        'email'         => ['required', 'unique:users'],
        'password' => 'sometimes|nullable|string|min:8',
    ];

    // Register all image uploads as a collection
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('healthworker_images')
            ->singleFile();
    }

    // Handle Image Upload and model relationship
    public function attachImage($file)
    {
        return $this->addMediaFromRequest($file)->toMediaCollection('healthworker_images');
    }


    // RELATIONSHIPS
    public function patientsEncounter()
    {
        return $this->hasMany(PatientEncounter::class, 'healthworker');
    }
}
