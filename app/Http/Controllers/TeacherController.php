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

    public function getScore($id=0){
        $course=$score=$chart=null;
        if($id>0){
            $course = Course::find($id);
            $score = Score::where('course_id',$id)->orderBy('score','DESC')->paginate();
            $chart = DB::table('score')->select(
                DB::raw('SUM(CASE WHEN score<60 THEN 1 ELSE 0 END) AS s1'),
                DB::raw('SUM(CASE WHEN score>=60 AND score<70 THEN 1 ELSE 0 END) AS s2'),
                DB::raw('SUM(CASE WHEN score>=70 AND score<80 THEN 1 ELSE 0 END) AS s3'),
                DB::raw('SUM(CASE WHEN score>=80 AND score<90 THEN 1 ELSE 0 END) AS s4'),
                DB::raw('SUM(CASE WHEN score>=90 THEN 1 ELSE 0 END) AS s5')
            )->where('course_id',$id)->first();
        }
        $courses = Course::where('teacher_id',request()->user->id)->get();
        return view('teacher.score')
            ->with('courses',$courses)
            ->with('course',$course)
            ->with('score',$score)
            ->with('chart',$chart);
    }
}
