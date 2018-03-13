<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['external_id', 'name', 'api_token', 'alive'];

    /**
     * This is to generate the API authentication token (if needed extra)
     *
     * @return mixed|string
     */
    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }
}
