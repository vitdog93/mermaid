<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'slug', 'description', 'created_by', 'updated_by'
    ];
}
