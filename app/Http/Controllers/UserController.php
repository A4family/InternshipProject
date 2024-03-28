<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\AuthService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param AuthService $authService
     */
    public function __construct(UserRepositoryInterface $userRepository, AuthService $authService)
    {
        $this->userRepository = $userRepository;
        $this->authService = $authService;
    }

    /**
     * Display form for user login
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     * @throws \Exception
     */
    public function userLoginForm(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        try {
            Redirect::setIntendedUrl(url()->previous());
            return view('userend.login');
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . $e);
            throw $e;
        }
    }


    /**
     * User register module
     * @param RegisterUserRequest $request
     * @return RedirectResponse
     */
    public function registerUser(RegisterUserRequest $request): RedirectResponse
    {
        return $this->userRepository->createUser($request->all());
    }

    /**
     * User login module
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function loginUser(LoginRequest $request): RedirectResponse
    {
        $credentials = ['username' => $request->username, 'password' => $request->password];

        return $this->authService->loginUser($credentials);
    }


    /**
     * User logout
     * @return RedirectResponse
     * @throws \Exception
     */
    public function logoutUser(): RedirectResponse
    {
        try {
            $guardName = 'web';
            $this->authService->logout($guardName);
            return redirect()->back();
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . $e);
            throw $e;
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     * @throws \Exception
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        try {
            return view('userend.index');
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . $e);
            throw $e;
        }
    }
}
