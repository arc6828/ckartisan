<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table ="profiles";
    protected $primaryKey = 'id';
    protected $fillable = ['role','user_id','photo','bank_name','bank_account'];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function fastworks(){
        return $this->hasMany('App\Fastwork', 'developer_id', 'user_id')->orderBy('created_at', 'desc');  
    }

    public function completed_part_time_fastworks(){
        return $this->hasMany('App\Fastwork', 'developer_id', 'user_id')
            ->join('projects','fastworks.project_id','=','projects.id')
            ->where('type','part-time')
            ->where('fastworks.status','completed')
            ->orderBy('created_at', 'desc')
            ->select('fastworks.*');  
    }

    public function reserved_part_time_fastworks(){
        return $this->hasMany('App\Fastwork', 'developer_id', 'user_id')
            ->join('projects','fastworks.project_id','=','projects.id')
            ->where('type','part-time')
            ->where('fastworks.status','reserved')
            ->orderBy('created_at', 'desc')
            ->select('fastworks.*');  
    }

    
    public function completed_fastworks(){
        return $this->hasMany('App\Fastwork', 'developer_id', 'user_id')->where('status','completed')->orderBy('created_at', 'desc');  
    }
    

}
