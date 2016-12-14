<?php
/**
 * Created by PhpStorm.
 * User: ChienHo
 * Date: 16/12/14
 * Time: 下午8:12
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    protected $table = 'speciality';

    protected $fillable = ['name','department_id'];

    public $timestamps = false;

    public function department(){
        return $this->belongsTo('App\Models\Department');
    }
}
