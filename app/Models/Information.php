<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends Model
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
        'version',
        'headline',
        'data',
    ];

    /**
    * Get the prunable model query.
    */
   public function prunable(): Builder
   {
       return static::where('deleted_at', '<=', now()->subMonth());
   }

}
