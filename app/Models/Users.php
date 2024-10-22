<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Model;

class Users extends Model implements Authenticatable
{
    use AuthenticableTrait;

    const ADMIN_TYPE = 'admin';
    const EDITOR_TYPE = 'editor';
    const DEFAULT_TYPE = 'user';

    protected $table = 'rix_users';
    protected $guarded = [];
    protected $primaryKey = 'user_id';

    public function post()
    {
        return $this->hasMany(Posts::class, 'author_id');
    }

    public function accessibility()
    {
        return \Auth::user()->role === self::ADMIN_TYPE || \Auth::user()->role === self::EDITOR_TYPE;
    }

    protected static function boot()
    {
        parent::boot();

        self::created(function () {
            Helper::clearCache('USERS','POSTS');
        });
        self::updated(function () {
            Helper::clearCache('USERS','POSTS');
        });
        self::deleted(function () {
            Helper::clearCache('USERS','POSTS');
        });
    }
}
