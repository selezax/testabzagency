<?php

namespace TestImgApi\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use TestImgApi\Models\Factories\UserInfoFactory;

class UserInfo extends Model
{
    use HasFactory;

    protected $with = ['position'];

    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'position_id',
        'address',
        'phone',
        'photo',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('tia.tables.users_info');
        parent::__construct($attributes);
    }

    protected function photo(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Str::startsWith($value, 'http') ?
                $value :
                (!empty($value) ? Storage::url($value) : '')
        );
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }

    public function position(){
        return $this->hasOne(Position::class, 'id', 'position_id');
    }

    protected static function newFactory()
    {
        return UserInfoFactory::new();
    }
}
