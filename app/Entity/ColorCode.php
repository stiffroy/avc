<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class ColorCode extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'color_code'];
}
