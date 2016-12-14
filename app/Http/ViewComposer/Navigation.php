<?php
/**
 * Created by PhpStorm.
 * User: ChienHo
 * Date: 16/12/14
 * Time: 下午1:04
 */

namespace App\Http\ViewComposer;


use Illuminate\View\View;

class Navigation
{
    protected $navigation=[];

    public function compose(View $view){

        $this->navigation['info']=[
            'title'=>trans('navigation.info'),
            'children'=>[
                'department'=>['title'=>trans('navigation.info_department'),'url'=>route('info:department')],
                'speciality'=>['title'=>trans('navigation.info_speciality'),'url'=>route('info:speciality')],
                'student'=>['title'=>trans('navigation.info_student'),'url'=>route('info:student')],
                'teacher'=>['title'=>trans('navigation.info_teacher'),'url'=>route('info:teacher')],
                'course'=>['title'=>trans('navigation.info_course'),'url'=>route('info:course')],
            ]
        ];



        $view->with('navigation',$this->navigation);
    }
}