<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $fillable = [
      'name', 'slug', 'description', 'created_by', 'updated_by'
    ];
}
