<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;

    use EntrustUserTrait; // add this trait to your user model

    // soft delete
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'position_id', 'position_name', 'job_id', 'job_name', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // 조회쿼리에서 제외할 열
    protected $hidden = [
        'password', 'remember_token',
    ];

    // 1:n 관계 지정 user - 1, documents - N
    public function documents() {
        return $this->hasMany('App\Document');
    }

    public function team() {
        return $this->belongsTo('App\Team');
    }

    public function job() {
        return $this->belongsTo('App\Job');
    }

    public function position() {
        return $this->belongsTo('App\Position');
    }

}
