<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\SegurityQuestion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
    public $successStatus = 200;

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|unique:users|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
                'question' => 'required',
                'answer' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $securityQuestion = SegurityQuestion::create([
            'user_id' => $user->id,
            'answer' => $input['answer'],
            'question' => bcrypt($input['question']),
        ]);

        $success['token'] = $user->createToken('AppName')->accessToken;
        return response()->json($success, $this->successStatus);
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('AppName')->accessToken;
            return response()->json($success, $this->successStatus);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function getUser()
    {
        $user = Auth::user();
        return response()->json($user, $this->successStatus);
    }

    public function getSecretQuestion(Request $request){

        $email = $request->input('email');
        $answer = $request->input('answer');

        $user = User::where('email', $email)->first();

        return response()->json($user->question->question, $this->successStatus);
    }

    public function reset(Request $request)
    {

        $email = $request->input('email');
        $answer = $request->input('code');
        $password = $request->input('password');

        $validator = Validator::make(
            $request->all(),
            [
                'answer' => 'required',
                'email' => 'required|exists:users|email',
                'password' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = User::where('email', $email)->first();

        if ($user->question->answer == bcrypt($answer)) {
            return response()->json(['error' => ['answer' => ['Respuest incorrecta']]], 401);
        }

        $user->password = bcrypt($password);
        $user->save();

        return response()->json(['message' => 'Password reestablecido con exito'], 200);
    }
}
