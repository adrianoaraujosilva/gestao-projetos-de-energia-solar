<?php

namespace App\Http\Controllers;

use App\Filters\UserFilter;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserTypeRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;


class IntegradorController extends Controller
{
    public function index(UserFilter $filters): JsonResponse
    {
        try {
            return $this->success(
                message: 'Lista de integradores',
                content: User::filter($filters)->paginate()
            );
        } catch (\Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function register(RegisterUserRequest $registerUserRequest): JsonResponse
    {
        try {
            return $this->success(
                message: 'Integrador cadastrado com sucesso',
                content: new UserResource(User::create($registerUserRequest->validated()))
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function login(LoginUserRequest $loginUserRequest): JsonResponse
    {
        try {
            if (Auth::attempt($loginUserRequest->validated()) && auth()->user()->isActive()) {
                return $this->success(
                    message: 'Login efetuado com sucesso',
                    content: auth()
                        ->user()
                        ->createToken("API TOKEN")
                        ->plainTextToken
                );
            }

            return $this->unauthorized();
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function update(User $user, UpdateUserRequest $updateUserRequest): JsonResponse
    {
        try {
            $updateUserRequest->validated();
            return $this->success(
                message: 'Integrador atualizado com sucesso',
                content: new UserResource(tap($user)->update(
                    $updateUserRequest->safe()->only([
                        'name',
                        'email',
                        'password',
                    ])
                ))
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function type(User $user, UpdateUserTypeRequest $updateUserTypeRequest): JsonResponse
    {
        try {
            $updateUserTypeRequest->validated();
            return $this->success(
                message: 'Tipo de integrador atualizado com sucesso',
                content: new UserResource(tap($user)->update(
                    $updateUserTypeRequest->safe()->only([
                        'type'
                    ])
                ))
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function active(User $user): JsonResponse
    {
        try {
            return $this->success(
                message: 'Integrador ativado com sucesso',
                content: new UserResource(tap($user)->update([
                    "active" => true
                ]))
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }

    public function deactive(User $user): JsonResponse
    {
        try {
            $user->tokens()->delete();
            return $this->success(
                message: 'Integrador ativado com sucesso',
                content: new UserResource(tap($user)->update([
                    "active" => false
                ]))
            );
        } catch (Throwable $th) {
            return $this->badRequest(message: $th);
        }
    }
}
