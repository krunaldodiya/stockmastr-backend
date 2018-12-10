<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use KD\Wallet\Traits\HasWallet;
use App\Events\UserWasCreated;
use Laravel\Passport\HasApiTokens;
use Hash;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasWallet;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'mobile', 'password', 'type', 'gender', 'dob', 'experience', 'sebi_number', 'city', 'state', 'avatar', 'profile_updated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes shows the list of events.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => UserWasCreated::class
    ];

    /**
     * Make sure to auto lowercase email field
     *
     * @var array
     */
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

}
