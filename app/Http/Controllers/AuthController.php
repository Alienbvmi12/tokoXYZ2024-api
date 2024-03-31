<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    private function responseJSON(int $status, string $messages, array $data = [])
    {
        http_response_code($status);
        return response()->json([
            'status' => $status,
            'message' => $messages,
            'data' => $data
        ], $status);
    }
    public function login(Request $request)
    {
        $vald =  Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        $valdrayy = $vald->messages()->toArray();

        if ($vald->fails()) {
            return $this->responseJSON(422, reset($valdrayy)[0]);
        }

        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;
            return $this->responseJSON(
                200,
                "success",
                ["token" => $token]
            );
        } else {
            return $this->responseJSON(
                422,
                "Incorrect username or password!!"
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

        $valdrayy = $vald->messages()->toArray();

        if ($vald->fails()) {
            return $this->responseJSON(422, $valdrayy[array_key_first($valdrayy)][0]);
        }

        $reqall = $request->all();
        $reqall["password"] = Hash::make($reqall["password"]);
        $res = User::create($reqall);

        return $this->responseJSON(200, "success", $res->toArray());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->responseJSON(200, "Logged out");
    }
}
