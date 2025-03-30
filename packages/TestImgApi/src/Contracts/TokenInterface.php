<?php

namespace TestImgApi\Contracts;

use Illuminate\Support\Str;
use TestImgApi\Models\Token;
use TestImgApi\Services\TokenService;

interface TokenInterface
{

    public function validateAndUseToken(string $token): bool;

    public function generateToken(): array;

    public function markTokenAsUsed(Token $tokenRecord): void;
}
