<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Получаем текущего аутентифицированного пользователя
        $user = auth()->user();

        // Извлекаем роль пользователя из таблицы model_has_roles и roles
        $role = $user->roles()->first(); // Предполагается, что у пользователя одна роль

        // Возвращаем токен и роль
        return response()->json([
            'token' => $token,
            'role' => $role ? $role->name : null, // Возвращаем имя роли
        ]);
    }

    // Логаут
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

    // Регистрация
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Присваиваем роль (по умолчанию)
        $defaultRole = Role::findByName('user'); // Убедитесь, что роль "user" существует
        $user->assignRole($defaultRole);

        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token], 201);
    }

    // Получение информации о текущем пользователе
    public function me()
    {
        $user = Auth::user();
        $role = $user->roles()->first();

        return response()->json([
            'user' => $user,
            'role' => $role ? $role->name : null,
        ]);
    }
}
