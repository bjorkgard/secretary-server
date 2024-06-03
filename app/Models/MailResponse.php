<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailResponse extends Model
{
    use HasFactory;
    use Prunable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier',
        'publisher_email',
        'description',
        'event',
        'description',
        'data',
        'fix',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'fix' => 'boolean',
        'data' => AsArrayObject::class,
    ];

    /**
    * Get the prunable model query.
    */
   public function prunable(): Builder
   {
       return static::where('deleted_at', '<=', now()->subMonth());
   }
}
