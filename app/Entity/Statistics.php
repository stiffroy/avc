<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['group_identifier', 'subgroup_identifier', 'data'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date', 'created_at', 'updated_at'];
}
