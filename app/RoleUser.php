<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    //
    protected $table = 'role_user';
    // created_at, updated_at 두개컬럼이 없다고 지정해주는것. save() 에서 영향을 미침.
    public $timestamps = false;
}
