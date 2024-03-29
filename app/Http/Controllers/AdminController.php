<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    private $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    //display login form
    /**
     * @throws \Exception
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        try {
            return view('backend.admin-login');
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . $e);
            throw $e;
        }
    }

    //login module
    public function login(LoginRequest $request): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            $credentials = $request->only(['username', 'password']);

            if ($this->authService->login($credentials)) {
                return redirect(route('admin.dashboard'));
            }

            return redirect()->back()->with('message', 'Invalid Credentials');
        } catch (\Exception $e) {
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . $e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }


    //logout module
    public function logout(): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $guardName = 'admin';
            $this->authService->logout($guardName);
            return redirect(route('admin.login'));
        } catch (\Exception $e) {
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . $e);
            throw $e;
        }
    }
}
