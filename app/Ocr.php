<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ocr extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ocrs';

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
    //protected $fillable = ['title', 'content', 'photo',];
    protected $fillable = ['title', 'content', 'photo','numbers','user_id','json_line','lineid','staffgaugeid','locationid','msgocrid'];

    public function staffgauge()
    {
        return $this->belongsTo('App\Staffgauge', 'staffgaugeid');
    }
}
