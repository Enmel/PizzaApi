<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Password_reset;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use App\Mail\PasswordResetCode;
use Illuminate\Support\Facades\Mail;

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
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('AppName')->accessToken;
        return response()->json($success, $this->successStatus);
    }


    public function login()
    {

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('AppName')->accessToken;
            return response()->json($success, $this->successStatus);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function getUser()
    {
        $user = Auth::user();
        return response()->json($user, $this->successStatus);
    }

    public function getCode(Request $request) {

        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if(empty($user)){
            return response()->json(['message' => "No existe ningun usuario con ese correo electronico"], 400);
        }

        $code = substr(md5(uniqid(mt_rand(), true)) , 0, 8);

        $old_token = Password_reset::where('email', $email)->first();

        Password_reset::create([
            'email' => $email,
            'token' => $code,
            'created_at' => Carbon::now()
        ]);

        Mail::to("emarval.fc@gmail.com")->send(new PasswordResetCode($user, $code));

        if(!empty($old_token)){
            $old_token->delete();
        }

        return response()->json(['message' => 'Codigo de reseteo enviado exitosamente'], 200);
    }

    public function reset(Request $request) {

        $email = $request->input('email');
        $reset_code = $request->input('code');
        $password = $request->input('password');

        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'required',
                'email' => 'required|exists:users|email',
                'password' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = User::where('email', $email)->first();

        if(empty($user)){
            return response()->json(['message' => "No existe ningun usuario con ese correo electronico"], 400);
        }

        $token = Password_reset::where('email', $email)->where('token', $reset_code)->first();

        if(empty($token)){
            return response()->json(['message' => "codigo reestablecimiento no encontrado"], 400);
        }

        $elapsed = Carbon::now()->diffInMinutes($token->created_at);

        if($elapsed > 30){
            return response()->json(['message' => "Codigo de reesstablecimiento vencido. Solicite uno nuevo"], 400);
        }

        $user->password = bcrypt($password);
        $user->save();

        return response()->json(['message' => 'Password reestablecido con exito'], 200);
    }
}
