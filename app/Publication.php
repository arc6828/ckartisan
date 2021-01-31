<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Publication extends Model
{
  protected $table = 'publications';
  protected $primaryKey = 'id';
  protected $guarded = [];



  public static function select_all()
  {
    return DB::table('publications')
      ->orderBy('year', 'desc')
      ->orderBy('month', 'desc')
      ->get();
  }

  public static function select_search($query)
  {
    return DB::table('publications')
      ->where($query)
      ->orderBy('year', 'desc')
      ->orderBy('month', 'desc')
      ->get();
  }

  public static function select_by_id($id)
  {
    return Publication::findOrFail($id);
  }

  public static function insert($input)
  {
    return DB::table('publications')
      ->insertGetId($input);
  }

  public static function update_by_id($input,$id)
  {
    DB::table('publications')
      ->where("id",$id)
      ->update($input);
  }

  public static function delete_by_id($id)
  {
    DB::table('publications')
      ->where("id",$id)
      ->delete();
  }
}
