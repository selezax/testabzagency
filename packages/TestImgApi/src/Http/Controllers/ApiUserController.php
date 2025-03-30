<?php

namespace TestImgApi\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use TestImgApi\Contracts\TokenInterface;
use TestImgApi\Contracts\UserItemInterface;
use TestImgApi\Contracts\UsersDataInterface;
use TestImgApi\Http\Requests\GetUserRequest;
use TestImgApi\Http\Requests\UserFormRequest;
use TestImgApi\Http\Requests\UserIndexRequest;
use TestImgApi\Http\Resources\PositionResource;
use TestImgApi\Http\Resources\SingleUserResource;
use TestImgApi\Http\Resources\TokenResource;
use TestImgApi\Http\Resources\UserCollectionResource;
use TestImgApi\Http\Resources\UserItemResource;
use TestImgApi\Http\Resources\UserResource;
use TestImgApi\Models\Position;

class ApiUserController extends Controller
{
    public function getToken(TokenInterface $token)
    {
        try {
            $tokenData = $token->generateToken();
            return (new TokenResource($tokenData))->resolve();

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate token'
            ], 500);
        }
    }

    public function createUser(UserFormRequest $request, UserItemInterface $user)
    {
        try {
            $user->registerUser($request->validated());
            return (new UserResource($user->getItem()))->resolve();

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $e->errors(),
            ], 422);

        } catch (Exception|RuntimeException $e) {
            Log::error($e->getMessage());

            if ($e->getCode() === 409) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 409);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to register user',
            ], 500);
        }
    }

    public function indexUsers(UserIndexRequest $request, UsersDataInterface $usersData)
    {
        try {
            $perPage = $request->validated('count', config('tia.defaultPerPage'));
            $page = $request->validated('page', 1);
            $users = $usersData->getByPaginate($page, $perPage);

            if ($users->isEmpty() && $page > 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Page not found',
                ], 404);
            }

            return ( new UserCollectionResource($users) )->resolve();

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve users',
            ], 500);
        }
    }

    public function getUser(GetUserRequest $request, $id)
    {
        try {
            $user = resolve(UserItemInterface::class)->findUserByItem($id);
            return ( new SingleUserResource($user) )->resolve();

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user',
            ], 500);
        }
    }

    public function indexPositions()
    {
        try {
            $positions = Position::orderBy('id', 'asc')->get();

            if ($positions->isEmpty()) {
                return response()->json([
                    "success" => false,
                    "message" => "Positions not found"
                ], 404);
            }

            return response()->json([
                'success' => true,
                'positions' => PositionResource::collection($positions),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve users',
            ], 500);
        }
    }
}
