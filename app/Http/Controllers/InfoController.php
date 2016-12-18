<?php
/**
 * Created by PhpStorm.
 * User: ChienHo
 * Date: 16/12/14
 * Time: 下午3:26
 */

namespace App\Http\Controllers;

use App\Facades\Json;
use App\Models\Speciality;
use App\Models\Department;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class InfoController
{
    public function getDepartment(Request $request){
        $search=$request->input('search');
        $department = Department::where(function($query)use($search){
            if($search){
                $query->where('name','like','%'.$search.'%')
                    ->orWhere('header','like','%'.$search.'%');
            }
        })->get();
        return view('info.department')->with('department',$department);
    }

    public function postDepartment(Request $request){
        $id = $request->input('id');
        if($id){
            $department = Department::find($id);
            if(!$department){
                return back()->with('message','学院不存在');
            }
        }else{
            $department = new Department;
        }
        $department->fill($request->all());
        $department->save();
        return redirect()->route('info:department');
    }

    public function deleteDepartment($id){
        $department = Department::find($id);
        if(!$department){
            return Json::response(102);
        }else{
            $department->delete();
            return Json::response(1);
        }
    }

    public function getSpeciality(Request $request){
        $id = intval($request->input('id'));
        $search = $request->input('search');
        $speciality = Speciality::where(function($query)use($id, $search){
            if($id >0){
                $query->where('department_id',$id);
            }
            if($search){
                $query->where('name','like','%'.$search.'%');
            }
        })->get();
        return view('info.speciality')
            ->with('department',getModelArray(Department::select('id','name')->get(),'id','name'))
            ->with('speciality',$speciality);
    }

    public function postSpeciality(Request $request){
        $id = $request->input('id');
        if($id){
            $speciality = Speciality::find($id);
            if(!$speciality){
                return back()->with('message',trans('response.103'));
            }
        }else{
            $speciality = new Speciality;
        }
        $speciality->fill($request->all());
        $speciality->save();
        return redirect()->route('info:speciality');
    }

    public function deleteSpeciality($id){
        $department = Speciality::find($id);
        if(!$department){
            return Json::response(103);
        }else{
            $department->delete();
            return Json::response(1);
        }
    }

    public function getStudent(Request $request){
        $id = intval($request->input('id'));
        $search = $request->input('search');
        $student = Student::where(function($query)use($id, $search){
            if ($id>0){
                $query->where('speciality_id',$id);
            }
            if ($search){
                $query->where('name','like','%'.$search.'%');
            }
        })->paginate();
        return view('info.student')->with('student',$student)
            ->with('speciality',getModelArray(Speciality::all(),['department','name','id'],'name'));
    }

    public function postStudent(Request $request){
        $id = $request->input('id');
        if($id){
            $student = Student::find($id);
            if(!$student){
                return back()->with('message',trans('response.104'));
            }
        }else{
            $student = new Student;
        }
        $student->fill($request->all());
        $student->save();
        return redirect()->route('info:student');
    }

    public function deleteStudent($id){
        $student = Student::find($id);
        if($student){
            $student->delete();
            return Json::response(1);
        }else{
            return Json::response(104);
        }
    }

    public function getTeacher(Request $request){
        $id = intval($request->input('id'));
        $search = $request->input('search');
        $teacher = Teacher::where(function ($query)use($id, $search){
            if($id>0){
                $query->where('speciality_id',$id);
            }
            if($search){
                $query->where('name','like','%'.$search.'%');
            }
        })->paginate();
        return view('info.teacher')->with('teacher',$teacher)
            ->with('speciality',getModelArray(Speciality::all(),['department','name','id'],'name'));
    }

    public function postTeacher(Request $request){
        $id = $request->input('id');
        if($id){
            $teacher = Teacher::find($id);
            if(!$teacher){
                return back()->with('message',trans('response.105'));
            }
        }else{
            $teacher = new Teacher;
        }
        $teacher->fill($request->all());
        $teacher->save();
        return redirect()->route('info:teacher');
    }

    public function deleteTeacher($id){
        $teacher = Teacher::find($id);
        if($teacher){
            $teacher->delete();
            return Json::response(1);
        }else{
            return Json::response(105);
        }
    }

    public function getCourse(Request $request){

    }

    public function postCourse(Request $request){

    }

    public function deleteCourse($id){

    }
}
