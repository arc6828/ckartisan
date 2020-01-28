<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'incomes';

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
    protected $fillable = ['title', 'remark', 'project_id', 'user_id', 'total', 'paid_date', 'receipt'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    
    public function project()
    {
        return $this->belongsTo('App\Project','project_id');
    }
}
