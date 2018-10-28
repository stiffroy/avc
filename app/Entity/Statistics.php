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
}
