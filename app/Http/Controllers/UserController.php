<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profession;
use App\Services\UserService;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        try {
            $userId = null;
            if (FacadesAuth::check()) {
                $userId = request()->user()->id;
            }
            // Get categoryId from query, if not present, it will be null
            $profession_id = $request->query('profession_id');

            // Get search from query, if not present, it will be null
            $search = $request->query('search');

            // Get location from query, if not present, it will be null
            $location = $request->query('location');

            // Start building the query
            $query = User::with(['profession']);

            if ($userId) {
                $query->whereNot('id', $userId);
            }

            // If categoryId exists in the query, apply the filter
            if ($profession_id) {
                $query->where('profession_id', $profession_id);
            }

            // If search exists in the query, apply the filter
            if ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            }

            // If search exists in the query, apply the filter
            if ($location) {
                $query->where('location', 'LIKE', "%{$location}%");
            }

            // Order by average_rating and paginate the results
            $users = $query->orderBy('average_rating', 'desc')->paginate(8);

            $professions = Profession::all();

            return view('user.index', ['users' => $users, 'professions' => $professions]);
        } catch (\Throwable $th) {
            return $this->apiError($th->getMessage(), [], 500);
        }
    }

    public function edit($user_id)
    {
        $user = User::find($user_id);
        $professions = Profession::all();

        if (!$user) {
            return response()->json(["error" => "User Not Found"],  404);
        }
        // return response()->json($user);
        return view('user.edit', ['user' => $user, 'professions' => $professions]);
    }

    public function show($user_id)
    {
        $user_id = (int) $user_id;
        $user = User::with(['profession', 'businesses'])->find($user_id);

        $reviews = $user->reviews()->with('reviewer')->paginate(5);

        if (!$user) {
            return response()->json(["error" => "User Not Found"],  404);
        }

        if (! auth()->check() || auth()->user()->id !== $user_id) {
            return view(
                'user.show',
                compact('user', 'reviews')
            );
        }
        return view(
            'user.profile',
            ['user' => $user, 'businesses' => $user->businesses]
        );
    }

    public function createUser(CreateUserRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('profile_pic')) {
                $imagePath = $request->file('profile_pic')->store('profile_pics', 'public');
                $validatedData['profile_pic'] = $imagePath;
            }
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

    // UserController.php

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'profession' => 'nullable|exists:professions,id',
            'password' => 'nullable|confirmed|min:8',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->profession_id = $request->input('profession');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($request->hasFile('profile_pic')) {
            // Delete old profile picture if exists
            if ($user->profile_pic && \Storage::exists('public/' . $user->profile_pic)) {
                \Storage::delete('public/' . $user->profile_pic);
            }
            $imagePath = $request->file('profile_pic')->store('profile_pics', 'public');
            $user->profile_pic = $imagePath;
        }

        $user->save();

        return redirect()->route('profile.show', $user->id)->with('Message', 'Profile updated successfully.');
    }

    public function reviewForm($id)
    {
        if (!auth()->check()) {
            return view('user.login');
        }
        return view('components.write-review', [
            'business_id' => '',
            'user_id' => $id
        ]);
    }
}
