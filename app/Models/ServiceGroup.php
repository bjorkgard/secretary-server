<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier',
        'service_group_identifier',
        'name',
        'responsible_email',
        'assistant_email',
        'email_status',
        'locale',
        'name'
    ];

    /**
     * Get the reports for the service group.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
