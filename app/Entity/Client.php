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
     * This is to generate the API authentication token (if needed extra)
     *
     * @return mixed|string
     */
    public function generateToken()
    {
        $this->api_token = str_random(60);

        return $this;
    }

    public function getStatusLabelAttribute()
    {
        $label = 'danger';
        if ($this->getHealthAttribute() === 'Warning') {
            $label = 'warning';
        } elseif ($this->getHealthAttribute() === 'Healthy') {
            $label = 'success';
        }

        return $label;
    }

    public function getBgAttribute()
    {
        $bg = 'red';
        if ($this->getHealthAttribute() === 'Warning') {
            $bg = 'yellow';
        } elseif ($this->getHealthAttribute() === 'Healthy') {
            $bg = 'green';
        }

        return $bg;
    }

    public function getHealthAttribute()
    {
        $warning = 300;
        $critical = 3000;
        $status = 'Healthy';
        $lastUpdate = Carbon::parse($this->updated_at);
        $now = Carbon::now();
        $diff = $now->diffInSeconds($lastUpdate);

        if ($diff > $critical) {
            $status = 'Critical';
        } elseif ($diff > $warning) {
            $status = 'Warning';
        }

        return $status;
    }
}
