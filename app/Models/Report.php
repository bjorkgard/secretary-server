<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_group_identifier',
        'identifier',
        'type',
        'name',
        'has_been_in_service',
        'has_not_been_in_service',
        'studies',
        'auxiliary',
        'hours',
        'remarks',
        'publisher_status',
        'publisher_name',
        'publisher_email',
        'has_been_updated',
        'email_status',
        'locale',
        'send_email',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'has_been_in_service' => 'boolean',
        'has_not_been_in_service' => 'boolean',
        'auxiliary' => 'boolean',
        'has_been_updated' => 'boolean',
        'send_email' => 'boolean',
    ];

    /**
     * Get the service group that owns the report.
     */
    public function serviceGroup(): BelongsTo
    {
        return $this->belongsTo(ServiceGroup::class);
    }
}
