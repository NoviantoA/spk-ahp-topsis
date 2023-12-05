<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $guarded = [];

    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->{$this->getRememberTokenName()};
    }

    public function setRememberToken($value)
    {
        $this->{$this->getRememberTokenName()} = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id');
    }
}
