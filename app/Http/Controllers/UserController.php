<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profession;
use App\Services\UserService;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use App\Services\CaptchaService;
use Illuminate\Support\Facades\Cache;


class UserController extends Controller
{
    protected $userService;
    protected $captchaService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->captchaService = new CaptchaService();
    }
    public function index(Request $request)
    {
        try {
            $users = $this->userService->getAllUsers($request);

            // Cache professions for efficiency
            $professions = Cache::remember('professions', 60 * 60, function () {
                return Profession::all();
            });

            $topMessage = "Professionals";
            if (!empty($request->profession)) {
                $topMessage = ucfirst($request->profession) . "s";
            }

            if (!empty($request->location)) {
                $topMessage .= " in " . $request->location;
            }

            return view('user.index', [
                'users' => $users,
                'professions' => $professions,
                "topMessage" => $topMessage
            ]);
        } catch (\Throwable $th) {
            return $this->apiError($th->getMessage(), [], 500);
        }
    }


    public function edit($user_id)
    {
        $user = User::find($user_id);
        $professions = Cache::remember('professions', 60 * 60, function () {
            return Profession::all();
        });

        if (!$user) {
            return response()->json(["error" => "User Not Found"],  404);
        }
        // return response()->json($user);
        return view('user.edit', ['user' => $user, 'professions' => $professions]);
    }

    public function show($username)
    {
        $user = User::with(['profession', 'businesses'])->where('username', $username)->first();

        if (!$user) {
            return response()->json(["error" => "User Not Found"],  404);
        }

        $reviews = $user->reviews()->with('reviewer')->latest()->paginate(5);
        $businesses = $user->businesses;

        $pageTitle = $user->name;
        $metaDescription = $user->bio;

        return view(
            'user.show',
            compact('user', 'reviews', 'businesses', 'metaDescription', 'pageTitle')
        );
    }

    public function profile($id)
    {
        $user = User::find($id);

        // $user = User::with(['profession', 'businesses'])->where('username', $username)->first();

        if (!$user) {
            return response()->json(["error" => "User Not Found"],  404);
        }

        $reviews = $user->reviews()->with('reviewer')->latest()->paginate(5);
        $businesses = $user->businesses;

        return view(
            'user.profile',
            compact('user', 'reviews', 'businesses')
        );
    }

    public function createUser(CreateUserRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $verifyCaptcha = $this->captchaService->verifyCaptcha($request);

            if (isset($verifyCaptcha['error'])) {
                return redirect()->back()->with('errorMessage', $verifyCaptcha['captchaErrorMessage']);
            }

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
            'location' => 'nullable|string',
            'bio' => 'nullable|string|max:1000'
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->profession_id = $request->input('profession');
        $user->location = $request->input('location');
        $user->bio = $request->input('bio');


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

        return back()->with('Message', 'Profile updated successfully.');
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
