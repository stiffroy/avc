<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function clients()
    {
        return $this->hasMany('App\Entity\Client');
    }
}
