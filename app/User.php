<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /*Code for New Accessrights*/
    public function roles()
    {
        return $this->belongsToMany(Role::class,'role_users');
    }



    public function scopeGetByUser($query, $id) 
    {
        $role = getUsersRole(Auth::User()->role_id);
        if (isAdmin(Auth::User()->role_id)) 
        {
            return $query;
        } 
        else 
        {
            return $query->where('id', Auth::User()->id);
        }
    }


    /*Give permission to access rights*/
    public function hasAccess(array $permissions)
    {
        foreach ($this->roles as $role) 
        {
            if ($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }


}
