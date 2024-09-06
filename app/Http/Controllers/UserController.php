<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        try {
            $users = $this->userService->getAllUsers();
            return response()->json($users);
        } catch (\Throwable $th) {
            return $this->apiError($th->getMessage(), [], 500);
        }
    }

    public function show($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(["error" => "User Not Found"],  404);
        }
        return response()->json($user);
    }

    public function createUser(CreateUserRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $user = $this->userService->createUser($validatedData);
            FacadesAuth::login($user);
            // return response()->json($user, 200);
            return redirect('/')->with("You have successfully register with us");
        } catch (\Throwable $th) {
            return $this->apiError($th->getMessage(), [], 500);
        }
    }

    public function deleteUser($user_id)
    {
        try {
            User::destroy($user_id);
            return response()->json(['User Delete Successfully']);
        } catch (\Throwable $th) {
            return $this->apiError($th->getMessage(), [], 500);
        }
    }
}
