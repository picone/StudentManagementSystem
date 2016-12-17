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
                return back()->with('message','专业不存在');
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

    }

    public function postStudent(Request $request){

    }

    public function deleteStudent($id){

    }
}
