<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. TAMBAHKAN VALIDASI UNTUK no_telepon
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_telepon' => 'required|string|max:15', // <-- Tambahkan ini
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 2. TAMBAHKAN no_telepon SAAT MEMBUAT USER
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telepon' => $request->no_telepon, // <-- Tambahkan ini


        ]);

        // Buat token untuk user yang baru register
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }


    // AuthController.php

public function login(Request $request)
{
    // Coba otentikasi user
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Email atau Password salah'], 401);
    }

    // Ambil user yang sudah berhasil login (CARA YANG BENAR)
    $user = Auth::user();

    // Buat token untuk user tersebut
    $token = $user->createToken('auth_token')->plainTextToken;

    // Kirim response dengan token dan data user
    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user,
    ]);
}

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Anda telah berhasil logout']);
    }
}
