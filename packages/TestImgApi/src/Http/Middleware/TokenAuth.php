<?php

namespace TestImgApi\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use TestImgApi\Contracts\TokenInterface;

class TokenAuth
{
    protected $tokenService;

    public function __construct(TokenInterface $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Token');

        if (!$token || !$this->tokenService->validateAndUseToken($token)) {
            return response()->json([
                'success' => false,
                'message' => 'The token expired or invalid.'
            ], 401);
        }

        return $next($request);
    }

}
