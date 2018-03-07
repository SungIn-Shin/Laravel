<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    // Documents(1) : Expenditure_historys(N) 관계 지정
    public function expenditureHistorys() {
        return $this->hasMany('App\ExpenditureHistory');
    }
    
    // Documents(1) : attachments(N) 관계 지정
    public function attachments() {
        return $this->hasMany('App\Attachment');
    }

    // Documents(1) : attachments(N) 관계 지정
    public function comments() {
        return $this->hasMany('App\Comment');
    }

    // Documents(N) : users(1) 역관계 지정
    public function user() {
        return $this->belongsTo('App\User');
    }
}
