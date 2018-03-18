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
    protected $fillable = ['name', 'external_id', 'api_token', 'alive'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'heartbeat_at'];

    /**
     * This is to generate the API authentication token (if needed extra)
     *
     * @return mixed|string
     */
    public function generateToken()
    {
        $this->api_token = str_random(60);

        return $this;
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

    private function getBaseHealthStatus()
    {
        return 'Not Active';
    }

    private function getHealthStatus($diff)
    {
        $warning = 300;
        $critical = 3000;
        $status = $this->getBaseHealthStatus();

        if ($diff > $critical) {
            $status = 'Critical';
        } elseif ($diff > $warning) {
            $status = 'Warning';
        } else {
            $status = 'Healthy';
        }

        return $status;
    }
}
