<?php

namespace App\Entity;

use App\Utilities\ClientUtilities;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'external_id', 'group_id', 'api_token', 'alive'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'heartbeat_at'];

    /**
     * The hooks to the entity
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function($client) {
            $client->api_token = ClientUtilities::generateToken();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Entity\User');
    }

    /**
     * Generate and set the API Token via Mutator method
     *
     * @param $status
     */
    public function setAliveAttribute($status)
    {
        $this->attributes['alive'] = ClientUtilities::convertStatus($status);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\Entity\Group');
    }

    /**
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        return ClientUtilities::getStatusLabel($this->getHealthAttribute());
    }

    /**
     * @return string
     */
    public function getBgAttribute()
    {
        return ClientUtilities::getBackground($this->getHealthAttribute());
    }

    /**
     * @return string
     */
    public function getBgIconAttribute()
    {
        return ClientUtilities::getBackgroundIcon($this->getHealthAttribute());
    }

    /**
     * @return string
     */
    public function getHealthAttribute()
    {
        return ClientUtilities::getHealth($this->heartbeat_at, $this->group->warning, $this->group->critical);
    }
}
