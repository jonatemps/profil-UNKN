<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Orchid\Attachment\Attachable;
use Orchid\Platform\Models\User as Authenticatable;
use Orchid\Screen\AsSource;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use AsSource, Attachable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
        'profile_photo_path'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];
    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'permissions',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
    ];

    protected $with = ['etude'];



    // public function attach()
    // {
    //     return $this->belongsTo(Attachment::class, 'carteId','id');
    // }
    // public function dossier(){
    //     return $this->belongsTo(Dossier::class,'id','user_id');
    // }

    public function identity(){
        return $this->belongsTo(Identity::class,'id','user_id');
    }

    public function etude(){
        return $this->belongsTo(Etude::class,'id','user_id');
    }

    public function occupation(){
        return $this->belongsTo(Occupation::class,'id','user_id');
    }

    public function choice(){
        return $this->belongsTo(Choice::class,'id','user_id');
    }

    public function checkAutoAdmis(){
        if ($this->choice->faculty1_id !=300 && $this->choice->faculty1_id !=400 && $this->choice->faculty1_id !=500 && substr($this->etude->pourcentage,0,2) >= 60 ) {
            return true;
        }else {
            return false;
        }
    }

}
