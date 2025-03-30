<?php

namespace TestImgApi\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = ['token', 'expires_at', 'used'];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('tia.tables.tokens');
        parent::__construct($attributes);
    }
}
