<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fastwork extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fastworks';

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
    protected $fillable = ['title', 'content', 'deadline', 'reserved_at', 'paid_at', 'completed_at','status', 'developer_id', 'project_id', 'user_id', 'remark', 'photo','hours','payment_id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function developer()
    {
        return $this->belongsTo('App\User', 'developer_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project','project_id');
    }

}
