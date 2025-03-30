<?php

namespace TestImgApi\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use TestImgApi\Models\Factories\PositionFactory;
use TestImgApi\Models\Factories\UserInfoFactory;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('tia.tables.positions');
        parent::__construct($attributes);
    }

    protected static function newFactory()
    {
        return PositionFactory::new();
    }
}
