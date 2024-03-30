<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Type\Integer;

class AuthController extends Controller
{

    private function responseJSON(int $status, array $messages, array $data = [])
    {
        return response()->json([
            'status' => $status,
            'messages' => $messages,
            'data' => $data
        ]);
    }
    public function login(Request $request)
    {
        $vald =  Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($vald->fails()) {
            return $this->responseJSON(422, $vald->messages()->toArray());
        }

        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;
            return $this->responseJSON(
                200,
                ["message" => "success"],
                ["token" => $token]
            );
        } else {
            return $this->responseJSON(
                422,
                ["message" => "Incorrect username or password!!"]
            );
        }
    }

    public function register(Request $request)
    {
        $vald =  Validator::make($request->all(), [
            'nama' => 'required|max:255',
            'username' => 'required|max:50|unique:users',
            'alamat' => 'required|min:3',
            'password' => 'required|confirmed'
        ]);

        if ($vald->fails()) {
            return $this->responseJSON(422, $vald->messages()->toArray());
        }

        $reqall = $request->all();
        $reqall["password"] = Hash::make($reqall["password"]);
        $res = User::create($reqall);

        return $this->responseJSON(200, ["message" => "success"], $res->toArray());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->responseJSON(200, ["message" => "Logged out"]);
    }
}
