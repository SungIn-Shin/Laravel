<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allimtalk extends Model
{
    protected $table = 'msg_data';
    // pk 지정
    protected $primaryKey = 'msg_seq';
}
