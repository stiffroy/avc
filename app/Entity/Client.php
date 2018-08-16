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
    protected $fillable = ['name', 'external_id', 'group_id', 'alive'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'heartbeat_at', 'notified_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'alive' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\Entity\Group');
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
        return ClientUtilities::getHealth($this->heartbeat_at, $this->group);
    }
}
