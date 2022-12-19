<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('dashboard.user.index');
    }

    public function create()
    {
        return view('dashboard.user.register');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:100',
            'password_confirmation' => 'required|min:8|max:30',
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|confirmed|min:8',
        ]);

        $response = $this->userService->registerUser($request);
        if (!$response) {
            return redirect()->route('admin.user.index')->with('fail', 'Fail to create a new user account.');
        }

        return redirect()->route('admin.user.index')->with('success', 'Successful to create a new user account.');
    }


    public function activate($id)
    {
        $response = $this->userService->activeUser($id);

        if ($response) {
            return redirect()->back()->with(['success' => 'Successfully Activated']);
        }
        return redirect()->back()->with(['fail' => 'Something went wrong']);
    }

    public function deactivate($id)
    {
        $response = $this->userService->deActiveUser($id);

        if ($response) {
            return redirect()->back()->with(['success' => 'Successfully Deactivated']);
        }
        return redirect()->back()->with(['fail' => 'Something went wrong']);
    }

    public function users(Request $request)
    {
        return response()->json($this->userService->makeDtCollection($request));
    }
}

