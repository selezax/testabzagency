<?php

namespace TestImgApi\Services;

use Illuminate\Support\Str;
use TestImgApi\Models\Token;
use TestImgApi\Contracts\TokenInterface;

class TokenService implements TokenInterface
{
    public function generateToken(): array
    {
        Token::where('expires_at', '<', now())->delete();

        $token = Str::random(180);
        $expiresAt = now()->addMinutes(40);

        $newToken = Token::create([
            'token' => $token,
            'expires_at' => $expiresAt,
            'used' => false,
        ]);

        return [
            'success' => true,
            'token' => $newToken->token
        ];
    }

    public function validateAndUseToken(string $token): bool
    {
        $tokenRecord = Token::where('token', $token)
            ->where('expires_at', '>', now())
            ->where('used', false)
            ->first();

        if ($tokenRecord) {
            $this->markTokenAsUsed($tokenRecord);
            return true;
        }

        return false;
    }

    public function markTokenAsUsed(Token $tokenRecord): void
    {
        $tokenRecord->update(['used' => true]);
    }
}
