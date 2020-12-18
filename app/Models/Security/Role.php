<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class Role extends \Spatie\Permission\Models\Role
{
    public static function defaultRoles()
    {
        return [
            'admin',
            'client',
            'executive'
        ];
    }
}
