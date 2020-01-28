<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'content', 'begin_date', 'deadline', 'complete_date', 'user_id', 'remark', 'photo','type'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function fastworks()
    {
        return $this->hasMany('App\Fastwork','project_id')->orderBy('created_at', 'desc');
    }

    public function paid_fastworks(){
        return $this->hasMany('App\Fastwork', 'project_id')->where('status','paid')->orderBy('created_at', 'desc');  
    }

}
