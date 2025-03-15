<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function showRegist()
    {
        return view('users.regist');
    }

    public function showLogin()
    {
        return view('users.login');
    }

    public function register(Request $request)
    {
        $rules = $this->user->validationRules();
        $messages = $this->user->validationMessages();
        $data = $request->only(['name', 'email', 'password', 'password_confirmation']);

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data['password'] = bcrypt($data['password']);
        $user = $this->user->create($data);

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'redirect' => route('home')
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->only(['email', 'password']);

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => url()->previous()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid Login Credentials!'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
