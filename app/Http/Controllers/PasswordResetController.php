<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordMailValidator;
use App\Http\Requests\ResetPasswordValidator;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     */
    public function index()
    {
        //
        return view('backend.forgot-password');
    }


    //send reset mail to the user
    public function sendResetMail(ForgotPasswordMailValidator $request)
    {
        $token = Str::random(64);

        try{
            DB::table('password_reset_tokens')->insert([
                'email' => $request->validated()['email'],
                'token' => $token,
                "created_at" => Carbon::now(),
            ]);

            Mail::send('backend.resetPasswordLink', ['token' => $token], function($message) use($request){
                $message->to($request->validated()['email']);
                $message->subject('Reset Password');
            });
            
            return back()->with('message', 'Your password reset link has been sent to your email.');
            
    
        }catch(\Exception $e){
            
        }
    }


    public function showNewPasswordForm(string $token){
        return view('backend.passwordReset', ['token'=> $token]);
    }


    public function submitResetPasswordForm(ResetPasswordValidator $request){
        try{
            $tokenData = DB::table('password_reset_tokens')->where('token', $request->validated()['token'])->first();

        if(!$tokenData):
            return back()->with(['message' => 'Invalid token id!!']);
        endif;
        

        User::where('email', $tokenData->email)->first()->update([
            'password' => Hash::make($request->validated()['new-password']),
        ]);

        DB::table('password_reset_tokens')->where('email', $tokenData->email)->delete();

        return redirect()->route('login')->with('message', 'Password successfully updated!!');
        }catch(\Exception $e){
            // dd($e);
        }
    }


   


}
