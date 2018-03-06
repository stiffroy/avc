<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['external_id', 'name', 'alive'];

    /**
     * Get the heartbeat associated with the client.
     */
    public function heartbeat()
    {
        return $this->hasOne('App\Models\Heartbeat');
    }
}
