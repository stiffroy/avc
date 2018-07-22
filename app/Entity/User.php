<?php

namespace App\Entity;

use App\Utilities\ApiUtilities;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Ultraware\Roles\Traits\HasRoleAndPermission;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'slack_webhook_url', 'api_token', 'preferred_method'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The hooks to the entity
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function($user) {
            $user->api_token = ApiUtilities::generateToken();
        });

        self::saving(function($user) {
            $user->api_token = $user->api_token ? $user->api_token : ApiUtilities::generateToken();
        });
    }

    /**
     * Hash the plain password and set it via the Mutator method
     *
     * @param $pass
     */
    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany('App\Entity\Group')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients()
    {
        return $this->hasMany('App\Entity\Client');
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @return mixed
     */
    public function routeNotificationForSlack()
    {
        return $this->slack_webhook_url;
    }
}
