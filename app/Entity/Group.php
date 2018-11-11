<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * Threshold value for warning in seconds
     */
    const WARNING = 300;

    /**
     * Threshold value for critical in seconds
     */
    const CRITICAL = 3000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'warning', 'critical'];

    /**
     * @var array
     */
    protected $attributes = [
        'warning' => self::WARNING,
        'critical' => self::CRITICAL,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients()
    {
        return $this->hasMany('App\Entity\Client');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Entity\User')->withTimestamps();
    }

    public function statistics()
    {
        return $this->hasMany('App\Entity\Statistics', 'group_identifier', 'name');
    }
}
