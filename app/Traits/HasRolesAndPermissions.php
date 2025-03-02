<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;
trait HasRolesAndPermissions
{

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isSuperAdmin()
    {
        if($this->roles->contains('slug', 'superadmin')){
            return true;
        }
    }
    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'users_permissions');
    }

 
    public function hasRole($role)
    {        
        if( strpos($role, ',') !== false ){//check if this is an list of roles

            $listOfRoles = explode(',',$role);

            foreach ($listOfRoles as $role) {                    
                if ($this->roles->contains('slug', $role)) {
                    return true;
                }
            }
        }else{                
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }

        return false;
    }
 
    public function hasPermission($role)
    { 
        if ($this->permissions->contains('slug', $role)) {
            return true;
        }
    }

    public function hasAnyRole($roles)
    {
      if(is_array($roles))
      {
        foreach ($roles as $role) {
          if($this->hasRoleSingle($role)){
            return true;
          }
        }
      }else{
        if($this->hasRoleSingle($roles)){
          return true;
        }
      }
      return false;
    }

    public function hasRoleSingle($role)
    {
      if($this->roles()->where('slug',$role)->first()){
        return true;
      }
      return false;
    }
}