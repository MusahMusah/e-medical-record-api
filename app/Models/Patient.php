<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    // Fillable field for mass assignment
    protected $fillable = [
        'name',
        'surname',
        'user_id',
        'age',
        'gender',
        'height',
        'weight',
        'bmi',
        'ward',
        'lga',
        'state',
        'image',
    ];

    // General Validation Rules for all Requests type
    public const VALIDATION_RULES = [
        'name'          => ['required', 'string', 'max:255'],
        'email'         => ['required', 'unique:users'],
    ];

    // Register all image uploads as a collection
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('patients_images')
            ->singleFile();
    }

    // Handle Image Upload and model relationship
    public function attachImage($file)
    {
        return $this->addMediaFromRequest($file)->toMediaCollection('patients_images');
    }

    public function scopeWithFilters($query, $byGender, $byAge)
    {
        foreach ($byAge as $value) {
            if ($value === '0-10') {
                $query->whereBetween('age', [0, 10]);
            }
            if ($value === '11-20') {
                $query->orWhereBetween('age', [11, 20]);
            }
            if ($value === '21-30') {
                $query->orWhereBetween('age', [21, 30]);
            }
            if ($value === '31-40') {
                $query->orWhereBetween('age', [31, 40]);
            }
            if ($value === '41-50') {
                $query->orWhereBetween('age', [41, 50]);
            }
            if ($value === '51-Above') {
                $query->orWhere('age', '>', '51');
            }
        }
        if (count($byGender) > 1) :
            $query->orWhereBetween('gender', $byGender);
        elseif(count($byGender) === 1) :
            $query->orWhere('gender', $byGender);
        endif;
        // count($byGender) > 1 ? $query->orWhereBetween('gender', $byGender) : $query;
    }
}
