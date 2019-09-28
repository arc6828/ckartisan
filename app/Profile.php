<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table ="profiles";
    protected $primaryKey = 'id';
    protected $fillable = ['role','user_id','photo'];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');       
    }

    public function fastworks(){        
        return $this->hasMany('App\Fastwork', 'developer_id', 'user_id');  
    }

}
