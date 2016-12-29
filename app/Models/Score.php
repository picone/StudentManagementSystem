<?php
/**
 * Created by PhpStorm.
 * User: ChienHo
 * Date: 16/12/29
 * Time: 下午2:37
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'score';

    public $timestamps = false;

    public function student(){
        return $this->belongsTo('App\Models\Student');
    }

    public function course(){
        return $this->belongsTo('App\Models\Course');
    }
}
