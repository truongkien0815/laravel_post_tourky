<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Auth;
use Mail;
use Validator;
use App\User;
use App\Model\Customer_forget_pass_otp;
use Carbon\Carbon;

use App\Model\ShopEmailTemplate;
use App\Mail\SendMail;
use App\Jobs\Job_SendMail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    //xử lý quên mật khẩu
    public function forget()
    {
        return view('auth.passwords.forget-password', [
            'seo_title' => 'Forget Password'
        ]);
    }
    public function actionForgetPassword(){
        $data = request()->all();
        if(empty($data['email']))
            return redirect()->back()->withInput()->withErrors('Please enter your email!');

        $user = User::where('email', $data['email'])->first();
        if($user)
        {
            $otp = rand(100000,999999);
            $customer = Customer_forget_pass_otp::create([
                'email' => $data['email'],
                'user_id' => $user->id,
                'otp_mail' => $otp,
                'status' => 0,
            ]);

            session()->put('otp_forget', $otp);
            session()->put('email_forget', $user->email);

            $this->send_mail($user, $otp);
            return redirect(route('forgetPassword_step2'));
        }
        else
            return view('auth.passwords.forget-password')->withErrors('Email not exist.');
    }

    public function send_mail($user, $otp)
    {
        $checkContent = ShopEmailTemplate::where('group', 'forgot_password')->where('status', 1)->first();
        if ($checkContent || $checkContent_admin) {
            $email_admin       = setting_option('email_admin');
            $company_name      = setting_option('company_name');

            $content = htmlspecialchars_decode($checkContent->text);
            
            $dataFind = [
                '/\{\{\$userName\}\}/',
                '/\{\{\$OTP\}\}/',
            ];
            $dataReplace = [
                $user->fullname,
                $otp
            ];

            $content = preg_replace($dataFind, $dataReplace, $content);

            $subject = $checkContent['subject']??'Forget Password';

            // dd($content);
            $dataView = [
                'content' => $content,
            ];
            $config = [
                'to' => $user->email,
                'subject' => $subject,
            ];

            $send_mail = new SendMail('email.content', $dataView, $config);
            Mail::send($send_mail);
            /*$sendEmailJob = new Job_SendMail($send_mail);
            dispatch($sendEmailJob);*/
        }
    }

    public function forgetPassword_step2(){
        session_start();
        if(!session()->has('otp_forget') && !session()->has('email_forget')){
            session_unset();
            session_destroy();
            return redirect()->route('forgetPassword', [
                'seo_title' => 'Forget Password'
            ]);
        } else{
            return view('auth.passwords.forget-password-step-2', [
                'seo_title' => 'Forgot password - Step 2'
            ]);
        }
    }

    public function actionForgetPassword_step2()
    {
        $data = request()->all();
        $customer_forget_pass_otp = Customer_forget_pass_otp::where('otp_mail', $data['otp_mail'])
            ->where('otp_mail', session('otp_forget'))
            ->where('status', 0)
            ->whereRaw("TIME_TO_SEC('".Carbon::now()."') - TIME_TO_SEC(created_at) < 600 ")
            ->first();
        if($customer_forget_pass_otp)
        {
            session()->put('otp_true', 1);
            return redirect()->route('forgetPassword_step3');
        }
        else
            return redirect()->back()->withErrors('OTP is not correct.');
    }

    public function forgetPassword_step3(){
        session_start();
        if(!session()->has('otp_forget') && !session()->has('email_forget') && !session()->has('otp_true'))
        {
            session_unset();
            session_destroy();
            return redirect()->route('forgetPassword');
        } else{
            return view('auth.passwords.forget-password-step-3', [
                'seo_title' => 'Forgot password - Step 3'
            ]);
        }
    }

    public function actionForgetPassword_step3(Request $rq){
        session_start();
        $customer_forget_pass_otp = Customer_forget_pass_otp::where('email', session('email_forget'))->where('otp_mail', session('otp_forget'))->where('status', 0)->first();

        if($customer_forget_pass_otp){
            $validator = Validator::make($rq->all(), [
                'new_password'     => 'required|min:3|required_with:confirm_new_password|same:confirm_new_password',
                'confirm_new_password'     => 'required|min:3',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                ->withErrors($validator);
            }
            $customer = User::where('email', '=', session('email_forget'))->first();
            $customer->password = bcrypt($rq->new_password);
            $customer->save();

            $customer_forget_pass_otp->status = 1;
            $customer_forget_pass_otp->save();

            session_unset();
            session_destroy();
            $msg = "Password has been changed.";
            $url=  route('user.login');
            if($msg) echo "<script language='javascript'>alert('".$msg."');</script>";
            echo "<script language='javascript'>document.location.replace('".$url."');</script>";
        } else{
            session_unset();
            session_destroy();
            return redirect()->route('forgetPassword');
        }
    }
}
