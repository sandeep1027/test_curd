<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
    'address',
    'lat',
    'lng'
  ];

  public static function deleteAddress($id)
  {
      $row = self::where('id', $id)->first();
      if (!empty($row)) {
          if ($row->delete()) {
              return true;
          }
      }
      return false;
  }
}
