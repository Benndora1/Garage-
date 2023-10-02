<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = ['role_slug', 'role_name', 'permissions'];

	/*Code for New Accessrights*/
    public function users()
    {
    	return $this->belongsToMany(User::class,'role_users');
    }

    
    public function scopeGetByUser($query, $id) 
    {
        $role = getUsersRole(Auth::User()->role_id);
        if (isAdmin(Auth::User()->role_id)) {
            return $query;
        } else {
            $query->whereHas('users', function ($q) use ($id) {
                $q->where("id", $id);
            });
        }
    }


    /*Give permission to access rights*/
    public function hasAccess(array $permissions)
    {
        foreach ($permissions as $permission) 
        {
            if ($this->hasPermission($permission)){
                return true;  
            } 
        }
        return false;
    }

    protected function hasPermission(string $permission)
    {
        $permissions = json_decode($this->permissions, true);
        return $permissions[$permission]??false;
    }




}
