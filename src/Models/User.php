<?php

namespace x96\SocialitePassport\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => AsArrayObject::class,
    ];

    /**
     * Check User role.
     *
     * @param  string  $roles
     * @return mixed
     */
    public function hasRole($roles) {
        $result = false;
        if (isset($this->permissions['roles'])) {
            foreach ($roles as $role) {
                if (in_array($role, $this->permissions['roles'])) {
                    $result = true;
                }
            }
        }
        return $result;
    }

    /**
     * Check User action.
     *
     * @param  string  $actions
     * @return mixed
     */
    public function hasAction($actions) {
        $result = false;
        if (isset($this->permissions['actions'])) {
            foreach ($actions as $action) {
                if (in_array($action, $this->permissions['actions'])) {
                    $result = true;
                }
            }
        }
        return $result;
    }

    /**
     * Check User permission.
     *
     * @param  string  $permissions
     * @return mixed
     */
    public function hasPermission($permissions) {
        $result = false;
        if (isset($this->permissions['roles'])) {
            foreach ($permissions as $permission) {
                if (in_array($permission, $this->permissions['roles'])) {
                    $result = true;
                }
            }
        }
        if (!$result && isset($this->permissions['actions'])) {
            foreach ($permissions as $permission) {
                if (in_array($permission, $this->permissions['actions'])) {
                    $result = true;
                }
            }
        }
        return $result;
    }
}
