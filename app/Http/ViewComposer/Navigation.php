<?php
/**
 * Created by PhpStorm.
 * User: ChienHo
 * Date: 16/12/14
 * Time: 下午1:04
 */

namespace App\Http\ViewComposer;


use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class Navigation
{
    protected $navigation = [];

    public function __construct(){
        $this->navigation = session('navigation');
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

            session(['navigation'=>$this->navigation]);
        }
        $view->with('navigation',$this->navigation);
    }
}