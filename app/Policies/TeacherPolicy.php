<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Teacher;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPolicy
{
    use HandlesAuthorization;

    public function view($user){
        return isset($user->id)&&$user->id>0;
    }

    public function management($user){
        return $user instanceof Admin;
    }

    public function resetPassword($user, Teacher $data){
        return $user instanceof Admin ||
            ($user instanceof Teacher && $user->id=$data->id);
    }

    public function course($user){
        return $user instanceof Teacher;
    }
}
