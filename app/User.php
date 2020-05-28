<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles, HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getListIncharge()
    {
        return self::orderBy('id', 'desc')->pluck('name', 'id');
    }
    public function messagesSent()
    {
    return $this->hasMany('App\Message', 'user_from', 'id');
    }

    public function messagesReceiver()
    {
    return $this->hasMany('App\Message', 'user_to', 'id');
    }

    public function getMessagesReceiverAttribute()
    {
        $messages = $this->messagesReceiver()->with("userFrom")->where('is_read', 0)->latest()->get();
        return $messages;
    }
    
    public function getMessagesReceiver10Attribute()
    {
        $messages = $this->messagesReceiver()->with("userFrom")->latest()->limit(10)->get();
        return $messages;
    }

    public function getMessagesSent10Attribute()
    {
        $messages = $this->messagesSent()->latest()->limit(10)->get();
        return $messages;
    }

    public function getLeaderAttribute()
    {
        try {
            $user_mantis = MANTIS_USER::where('email', $this->email)->first();
            $leader_mantis_email = $user_mantis->USER_GROUP->TEAM->leadInfo->email;
            return User::where('email', $leader_mantis_email)->first();
        } catch (\Throwable $th) {
            return null;
        }
    }
}
