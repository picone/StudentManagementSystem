<?php
/**
 * Created by PhpStorm.
 * User: ChienHo
 * Date: 16/12/14
 * Time: 下午3:26
 */

namespace App\Http\Controllers;

use App\Facades\Json;
use App\Models\Course;
use App\Models\Speciality;
use App\Models\Department;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InfoController extends Controller
{
    public function getDepartment(Request $request){
        $this->authorizeForUser($request->user,'management',Department::class);
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
        $this->authorizeForUser($request->user,'management',Department::class);
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
        $this->authorizeForUser(request()->user,'management',Department::class);
        $department = Department::find($id);
        if(!$department){
            return Json::response(102);
        }else{
            $department->delete();
            return Json::response(1);
        }
    }

    public function getSpeciality(Request $request){
        $this->authorizeForUser($request->user,'management',Speciality::class);
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
        $this->authorizeForUser($request->user,'management',Speciality::class);
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
        $this->authorizeForUser(request()->user,'management',Speciality::class);
        $department = Speciality::find($id);
        if(!$department){
            return Json::response(103);
        }else{
            $department->delete();
            return Json::response(1);
        }
    }

    public function getStudent(Request $request){
        $this->authorizeForUser($request->user,'management',Student::class);
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
        $this->authorizeForUser($request->user,'management',Student::class);
        $id = $request->input('id');
        if($id){
            $student = Student::find($id);
            if(!$student){
                return back()->with('message',trans('response.104'));
            }
        }else{
            $student = new Student;
            $student->password = Hash::make('123456');
        }
        $student->fill($request->all());
        $student->save();
        return redirect()->route('info:student');
    }

    public function deleteStudent($id){
        $this->authorizeForUser(request()->user,'management',Student::class);
        $student = Student::find($id);
        if($student){
            $student->delete();
            return Json::response(1);
        }else{
            return Json::response(104);
        }
    }

    public function resetStudentPassword(Request $request){
        $student = Student::find($request->input('id'));
        if($student){
            $this->authorizeForUser($request->user,'resetPassword',$student);
            $student->password = Hash::make($request->input('password'));
            $student->save();
            return back()->with('message',trans('response.1'));
        }else{
            return back()->with('message',trans('response.104'));
        }
    }

    public function getTeacher(Request $request){
        $this->authorizeForUser($request->user,'management',Teacher::class);
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
        $this->authorizeForUser($request->user,'management',Teacher::class);
        $id = $request->input('id');
        if($id){
            $teacher = Teacher::find($id);
            if(!$teacher){
                return back()->with('message',trans('response.105'));
            }
        }else{
            $teacher = new Teacher;
            $teacher->password = Hash::make('123456');
        }
        $teacher->fill($request->all());
        $teacher->save();
        return redirect()->route('info:teacher');
    }

    public function deleteTeacher($id){
        $this->authorizeForUser(request()->user,'management',Teacher::class);
        $teacher = Teacher::find($id);
        if($teacher){
            $teacher->delete();
            return Json::response(1);
        }else{
            return Json::response(105);
        }
    }

    public function resetTeacherPassword(Request $request){
        $teacher = Teacher::find($request->input('id'));
        if($teacher){
            $this->authorizeForUser($request->user,'resetPassword',$teacher);
            $teacher->password = Hash::make($request->input('password'));
            $teacher->save();
            return back()->with('message',trans('response.1'));
        }else{
            return back()->with('message',trans('response.105'));
        }
    }

    public function getCourse(Request $request){
        $this->authorizeForUser(request()->user,'management',Course::class);
        $id = intval($request->input('id'));
        $search = $request->input('search');
        $course = Course::where(function($query)use($search){
            if($search){
                $query->where('name','like','%'.$search.'%');
            }
        });
        if($id>0){
            $course = $course->whereHas('teacher.speciality',function($query)use($id){
                $query->where('id',$id);
            });
        }
        $course = $course->paginate();
        return view('info.course')->with('course',$course)
            ->with('speciality',getModelArray(Speciality::all(),['department','name','id'],'name'))
            ->with('teacher',getModelArray(Teacher::select('id','name')->get(),'id','name'));
    }

    public function postCourse(Request $request){
        $this->authorizeForUser($request->user,'management',Course::class);
        $id = $request->input('id');
        if($id){
            $course = Course::find($id);
            if(!$course){
                return back()->with('message',trans('response.106'));
            }
        }else{
            $course = new Course;
        }
        $course->fill($request->all());
        $course->save();
        return redirect()->route('info:course');
    }

    public function deleteCourse($id){
        $this->authorizeForUser(request()->user,'management',Course::class);
        $course = Course::find($id);
        if($course){
            $course->delete();
            return Json::response(1);
        }else{
            return Json::resposne(106);
        }
    }
}
