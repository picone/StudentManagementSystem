<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Student;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    public function view($user){
        return isset($user->id)&&$user->id>0;
    }

    public function management($user){
        return $user instanceof Admin;
    }

    public function resetPassword($user, Student $data){
        return $user instanceof Admin ||
            ($user instanceof Student && $user->id=$data->id);
    }
}
