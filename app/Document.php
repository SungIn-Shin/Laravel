<?php

namespace App;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class Document extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;
    
    public function attachments() {
        return $this->hasMany('App\Attachment');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function team() {
        return $this->belongsToThrough(Team::class, User::class);
    }

    public function changeInspectionStatus($status) {
        switch ($status) {
            case "REJ" : 
                return "반려";
                break;
            case "APR":
                return "승인";
                break;            
            default:
                return "검토중";
                break;                                                                          
        }
    }

    public function changeStatus($status) {
        switch ($status) {
            case "REG" : 
                return "검토대기";
                break;
            case "APR":
                return "승인";
                break;            
            default:
                return "검토중";
                break;                                                                          
        }
    }

   
}
