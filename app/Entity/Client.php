<?php

namespace App\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    const NO_RECORDS_YET = 'No records yet';
    const WARNING = 'Warning';
    const CRITICAL = 'Critical';
    const HEALTHY = 'Healthy';

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
        if ($this->getHealthAttribute() === self::HEALTHY) {
            $label = 'success';
        } elseif ($this->getHealthAttribute() === self::WARNING) {
            $label = 'warning';
        } elseif ($this->getHealthAttribute() === self::CRITICAL) {
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
        if ($this->getHealthAttribute() === self::HEALTHY) {
            $bg = 'green';
        } elseif ($this->getHealthAttribute() === self::WARNING) {
            $bg = 'yellow';
        } elseif ($this->getHealthAttribute() === self::CRITICAL) {
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
        if ($this->getHealthAttribute() === self::WARNING || $this->getHealthAttribute() === self::CRITICAL) {
            $bgIcon = 'ion-heart-broken';
        } elseif ($this->getHealthAttribute() === self::HEALTHY) {
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
        return self::NO_RECORDS_YET;
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
            $status = self::CRITICAL;
        } elseif ($diff > $warning) {
            $status = self::WARNING;
        } elseif ($diff < $warning) {
            $status = self::HEALTHY;
        }

        return $status;
    }
}
