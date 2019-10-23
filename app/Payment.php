<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payments';

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
    protected $fillable = ['total', 'user_id', 'remark', 'paid_at', 'receipt'];

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
    public function fastworks(){
        return $this->hasMany('App\Fastwork','payment_id');
    }
    
}
