<?php

namespace App\Entity;

use Carbon\Carbon;
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
            $client->api_token = $client->generateToken();
            $client->alive = $client->alive ? 1 : 0;
        });
    }

    /**
     * This is to generate the API authentication token (if needed extra)
     *
     * @return mixed|string
     */
    public function generateToken()
    {
        $token = str_random(60);

        return $token;
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
        $label = 'info';
        if ($this->getHealthAttribute() === 'Healthy') {
            $label = 'success';
        } elseif ($this->getHealthAttribute() === 'Warning') {
            $label = 'warning';
        } elseif ($this->getHealthAttribute() === 'Critical') {
            $label = 'danger';
        }

        return $label;
    }

    /**
     * @return string
     */
    public function getBgAttribute()
    {
        $bg = 'aqua';
        if ($this->getHealthAttribute() === 'Healthy') {
            $bg = 'green';
        } elseif ($this->getHealthAttribute() === 'Warning') {
            $bg = 'yellow';
        } elseif ($this->getHealthAttribute() === 'Critical') {
            $bg = 'red';
        }

        return $bg;
    }

    /**
     * @return string
     */
    public function getBgIconAttribute()
    {
        $bgIcon = 'ion-flag';
        if ($this->getHealthAttribute() === 'Warning' || $this->getHealthAttribute() === 'Critical') {
            $bgIcon = 'ion-heart-broken';
        } elseif ($this->getHealthAttribute() === 'Healthy') {
            $bgIcon = 'ion-heart';
        }

        return $bgIcon;
    }

    /**
     * @return string
     */
    public function getHealthAttribute()
    {
        $now = Carbon::now();
        $status = $this->getBaseHealthStatus();
        if ($this->heartbeat_at) {
            $diff = $now->diffInSeconds(Carbon::parse($this->heartbeat_at));
            $status = $this->getHealthStatus($diff);
        }

        return $status;
    }

    /**
     * @return string
     */
    private function getBaseHealthStatus()
    {
        return 'No records yet';
    }

    /**
     * @param $diff
     * @return string
     */
    private function getHealthStatus($diff)
    {
        $warning = $this->group->warning;
        $critical = $this->group->critical;
        $status = $this->getBaseHealthStatus();

        if ($diff > $critical) {
            $status = 'Critical';
        } elseif ($diff > $warning) {
            $status = 'Warning';
        } elseif ($diff < $warning) {
            $status = 'Healthy';
        }

        return $status;
    }
}
