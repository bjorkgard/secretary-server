<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Congregation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier',
        'congregation',
        'congregation_number',
        'contact_firstname',
        'contact_lastname',
        'contact_email',
        'public',
        'send_service_group_reports',
        'send_publisher_reports',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'send_service_group_reports' => 'boolean',
        'send_publisher_reports' => 'boolean',
        'public' => 'boolean',
    ];
}
