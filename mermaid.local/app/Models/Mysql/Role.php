<?php

namespace App\Models\Mysql;

use \PHPZen\LaravelRbac\Model\Role as Roles;

class Role extends Roles
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'slug', 'description', 'created_by', 'updated_by'
    ];
}
