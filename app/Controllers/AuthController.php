<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Actions\User\RegisterUser;
use App\Actions\Event\RecordEvent;
use App\Core\Auth;
use App\Enums\EventAction;
use PDOException;
use App\Repositories\UserRepository;

class AuthController
{
    public function logout(): string
    {
        if (!valid_csrf_token()) {
            http_response_code(403);
            return 'Invalid form token.';
        }

        (new RecordEvent())->execute(Auth::user()->getId(), EventAction::Logout);
        Auth::logout();

        header('Location: ' . route('home'), true, 303);
        return '';
    }

    public function login(): string
    {
        return view('auth/login', [
            'pageTitle' => 'Login page',
            'error' => null,
            'name' => '',
            'email' => '',
        ]);
    }

    public function login_post()
    {
        if (!valid_csrf_token()) {
            http_response_code(403);
            return 'Invalid form token.';
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!is_string($email) || !is_string($password)) {
            http_response_code(400);
            return 'Invalid form data.';
        }

        $credentials = (new UserRepository())->findCredentialsByEmail(trim($email));

        if (
            $credentials === null
            || !password_verify($password, $credentials['password'])
        ) {
            return view('auth/login', [
                'pageTitle' => 'Login page',
                'error' => 'Invalid email or password.',
                'email' => $email,
            ]);
        }

        (new RecordEvent())->execute($credentials['id'], EventAction::Login);
        Auth::login($credentials['id']);

        header('Location: ' . route('home'), true, 303);
        return '';
    }

    public function register(): string
    {
        return view('auth/register', [
            'pageTitle' => 'Register',
            'error' => null,
            'name' => '',
            'email' => '',
        ]);
    }

    public function register_post(): string
    {
        if (!valid_csrf_token()) {
            http_response_code(403);
            return 'Invalid form token.';
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirmation = $_POST['password_confirmation'] ?? '';

        if (
            !is_string($name)
            || !is_string($email)
            || !is_string($password)
            || !is_string($passwordConfirmation)
        ) {
            http_response_code(400);
            return 'Invalid form data.';
        }

        if ($password !== $passwordConfirmation) {
            return view('auth/register', [
                'pageTitle' => 'Register',
                'error' => 'Passwords do not match.',
                'name' => $name,
                'email' => $email,
            ]);
        }

        try {
            $userId = (new RegisterUser())->execute($name, $email, $password);
        } catch (\InvalidArgumentException $exception) {
            $error = $exception->getMessage();
        } catch (PDOException $exception) {
            if (($exception->errorInfo[1] ?? null) !== 1062) {
                throw $exception;
            }

            $error = 'Email is already registered.';
        }

        if (isset($error)) {
            return view('auth/register', [
                'pageTitle' => 'Register',
                'error' => $error,
                'name' => $name,
                'email' => $email,
            ]);
        }

        Auth::login($userId);

        header('Location: ' . route('home'), true, 303);
        return '';
    }
}
