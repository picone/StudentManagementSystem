<?php
/**
 * Created by PhpStorm.
 * User: ChienHo
 * Date: 16/12/14
 * Time: 下午1:04
 */

namespace App\Http\ViewComposer;


use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class Navigation
{
    protected $navigation = [];

    public function __construct(){
        //$this->navigation = session('navigation');
    }

    public function compose(View $view){
        if(!$this->navigation||env('APP_DEBUG')){
            $this->navigation['info']['title']=trans('navigation.info');
            foreach (['department','speciality','student','teacher','course'] as $item){
                if(Gate::forUser(request()->user)->allows('management','App\Models\\'.ucfirst($item))){
                    $this->navigation['info']['children'][$item]=[
                        'title'=>trans('navigation.info_'.$item),
                        'url'=>route('info:'.$item)
                    ];
                }
            }
            if(!isset($this->navigation['info']['children']))unset($this->navigation['info']);

            if(Gate::forUser(request()->user)->allows('management',Course::class)){
                $this->navigation['course']['title'] = trans('navigation.course');
                foreach(['choose','management'] as $item){
                    $this->navigation['course']['children'][$item]=[
                        'title'=>trans('navigation.course_'.$item),
                        'url'=>route('course:'.$item)
                    ];
                }
            }

            if(Gate::forUser(request()->user)->allows('course',Teacher::class)){
                $this->navigation['teacher'] = [
                    'title' => trans('navigation.teacher'),
                    'url' => route('teacher:course')
                ];
            }
            session(['navigation'=>$this->navigation]);
        }
        $view->with('navigation',$this->navigation);
    }
}