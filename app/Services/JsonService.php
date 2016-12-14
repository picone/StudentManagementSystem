<?php
/**
 * Created by PhpStorm.
 * User: ChienHo
 * Date: 16/12/14
 * Time: 上午1:36
 */

namespace app\Services;


class JsonService
{
    /**
     * @param int $code 错误代码
     * @param null $data 附加数据
     * @param string $msg 错误信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($code=1, $data=null, $msg='')
    {
        $return['code']=$code;
        if($msg==''){
            $msg=trans('response.'.$code);
            if($msg)$return['msg']=$msg;
        }else{
            $return['msg']=$msg;
        }
        if(!is_null($data))$return['data']=$data;
        return response()->json($return);
    }
}