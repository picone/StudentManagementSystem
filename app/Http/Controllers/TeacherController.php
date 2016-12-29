<?php
/**
 * Created by PhpStorm.
 * User: ChienHo
 * Date: 16/12/29
 * Time: 下午7:33
 */

namespace App\Http\Controllers;


use App\Facades\Json;
use App\Models\Course;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function getCourse(Request $request){
        $course = Course::has('scores')->where('teacher_id',$request->user->id)->get();
        return view('teacher.course')
            ->with('course',$course);
    }

    public function postScore(Request $request){
        $where = ['course_id'=>$request->input('course'),'student_id'=>$request->input('id')];
        DB::table('score')->where($where)
            ->update(['regular_score'=>$request->input('regular_score','null'),'exam_score'=>$request->input('exam_score','null')]);
        $score = Score::where($where)->first();
        return Json::response(1,['score'=>$score->score]);
    }
}
