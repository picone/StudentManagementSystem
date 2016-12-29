<?php
/**
 * Created by PhpStorm.
 * User: ChienHo
 * Date: 16/12/18
 * Time: 下午6:17
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';


    protected $fillable = ['name','hour','credit','teacher_id'];

    public $timestamps = false;

    public function teacher(){
        return $this->belongsTo('App\Models\Teacher');
    }

    public function scores(){
        return $this->hasMany('App\Models\Score');
    }
}