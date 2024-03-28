<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\Admin;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\returnSelf;

class PasswordResetController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws \Exception
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        try {
            return view('backend.forgot-password');
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . $e);
            throw $e;
        }
    }


    /**
     * Send reset mail to user
     * @param ForgotPasswordRequest $request
     * @return RedirectResponse
     */
    public function sendResetMail(ForgotPasswordRequest $request): RedirectResponse
    {
        $token = Str::random(64);
        try{
            DB::table('password_reset_tokens')->insert([
                'email' => $request->validated()['email'],
                'token' => $token,
                "created_at" => Carbon::now(),
            ]);
            Mail::send('backend.reset-password-link', ['token' => $token], function($message) use($request){
                $message->to($request->validated()['email']);
                $message->subject('Reset Password');
            });
            return back()->with('message', 'Your password reset link has been sent to your email.');
        }catch(\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . $e);
            return back()->with('message', $e->getMessage());
        }
    }


    /**
     * Display form for password submission
     * @throws \Exception
     */
    public function showNewPasswordForm(string $token): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        try {
            return view('backend.password-reset', ['token'=> $token]);
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . json_encode($e->getTrace(), JSON_PRETTY_PRINT));
            throw $e;
        }
    }


    /**
     * Store new password
     * @param ResetPasswordRequest $request
     * @return string|RedirectResponse
     * @throws \Exception
     */
    public function submitAdminNewPassword(ResetPasswordRequest $request): string|RedirectResponse
    {
        try{
            $tokenData = DB::table('password_reset_tokens')->where('token', $request->validated()['token'])->first();
        if(!$tokenData){
            return back()->with(['message' => 'Invalid token id!!']);
        }
        Admin::where('email', $tokenData->email)->first()->update([
            'password' => Hash::make($request->validated()['new-password']),
        ]);
        DB::table('password_reset_tokens')->where('email', $tokenData->email)->delete();
        return redirect()->route('admin.login')->with('message', 'Password successfully updated!!');
        }catch(\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . $e);
            throw $e;
        }
    }
}
