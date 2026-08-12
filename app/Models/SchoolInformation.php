<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolInformation extends Model
{
/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'school_information';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_bn',
        'name_en',
        'school_code',
        'eiin',
        'school_type',
        'management_type',
        'established_year',
        'recognition_no',
        'recognition_date',
        'division',
        'district',
        'upazila',
        'union_ward',
        'village_area',
        'post_office',
        'post_code',
        'address',
        'phone',
        'alternate_phone',
        'email',
        'website',
        'emergency_phone',
        'logo_square_path',
        'logo_circle_path',
        'favicon_path',
        'head_name_bn',
        'head_name_en',
        'head_designation_bn',
        'head_designation_en',
        'motto',
        'description',
        'mission',
        'vision',
        'social_links',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'established_year' => 'integer',
        'recognition_date' => 'date',
        'social_links' => 'array',
    ];

    /**
     * Appended virtual attributes.
     */
    protected $appends = [
        'logo_square_url',
        'logo_circle_url',
        'favicon_url',
    ];

    /**
     * Get the Square Logo URL directly from the public path.
     */
    public function getLogoSquareUrlAttribute(): string
    {
        if ($this->logo_square_path && file_exists(public_path($this->logo_square_path))) {
            return asset($this->logo_square_path);
        }
        return asset('images/defaults/square-logo.png');
    }

    /**
     * Get the Circle Logo URL directly from the public path.
     */
    public function getLogoCircleUrlAttribute(): string
    {
        if ($this->logo_circle_path && file_exists(public_path($this->logo_circle_path))) {
            return asset($this->logo_circle_path);
        }
        return asset('images/defaults/circle-logo.png');
    }

    /**
     * Get the Favicon URL directly from the public path.
     */
    public function getFaviconUrlAttribute(): string
    {
        if ($this->favicon_path && file_exists(public_path($this->favicon_path))) {
            return asset($this->favicon_path);
        }
        return asset('images/defaults/favicon.ico');
    }



}
