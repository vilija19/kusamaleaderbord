<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validator extends Model
{

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
    
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Accesor for the valid attribute.
     * Get validity status.
     *
     * @param  string  $value
     * @return void
     */
    public function getValidAttribute($value)
    {
        if ($value == 2) {
            return 'Unknown';
        }
    }

    use HasFactory;
}
