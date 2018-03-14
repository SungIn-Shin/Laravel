<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    public function users () {
        return $this->hasMany('App\User');
    }

    public function documents() {
        return $this->hasManyThrough('App\Document', 
                                     'App\User', 
                                     'team_id', 
                                     'user_id', 
                                     'id', 
                                     'id');
    }

}
