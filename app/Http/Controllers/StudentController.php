<?php
/**
 * Created by PhpStorm.
 * User: ChienHo
 * Date: 16/12/29
 * Time: 下午11:30
 */

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getCourse($order='time'){
        $score = Score::where('student_id',request()->user->id)->orderBy($order=='time'?'createAt':'score','DESC')->get();
        return view('student.course')
            ->with('score',$score);
    }
}