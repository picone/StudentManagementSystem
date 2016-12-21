<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    public function view($user){
        return isset($user->id)&&$user->id>0;
    }

    public function management($user){
        return $user instanceof Admin;
    }
}
