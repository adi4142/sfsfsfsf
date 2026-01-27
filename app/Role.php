<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'roles_id';
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->hasMany(User::class, 'roles_id', 'roles_id');
    }

}
