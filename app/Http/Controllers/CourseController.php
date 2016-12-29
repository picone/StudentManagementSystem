<?php
/**
 * Created by PhpStorm.
 * User: ChienHo
 * Date: 16/12/29
 * Time: 上午4:08
 */
namespace App\Http\Controllers;

use App\Facades\Json;
use App\Models\Course;
use App\Models\Speciality;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function getChoose(){
        $course = Course::get();
        return view('course.choose')
            ->with('speciality',getModelArray(Speciality::all(),['department','name','id'],'name'))
            ->with('course',$course);
    }

    public function getStudent(Request $request){
        $data = Student::select('id','name')->where('speciality_id',$request->input('id'))->get();
        return Json::response(1,$data);
    }

    public function postChoose(Request $request){
        $student = $request->input('student');
        if(count($student)==0){
            return back()->with('message','请选择学生');
        }
        $course = $request->input('course',false);
        if(!$course){
            return back()->with('message','请选择课程');
        }
        $term = $request->input('term');
        $data = array();
        foreach($student as $val){
            $data[] = [
                'student_id' => $val,
                'course_id' => $course,
                'term' => $term
            ];
        }
        DB::table('score')->insert($data);
        return back()->with('message','成功');
    }

    public function getManagement(){

    }
}
