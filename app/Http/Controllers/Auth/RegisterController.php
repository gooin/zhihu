<?php

namespace App\Http\Controllers\Auth;

use App\Mailer\UserMailer;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => '/images/avatars/default.png', // 默认头像
            'confirmation_token' => str_random(40), // user
            'password' => bcrypt($data['password']),
            'api_token' => str_random(60), // api请求时用到的token
        ]);

        $this->sendVerifyEmailTo($user);
        return $user;
    }

    private function sendVerifyEmailTo($user)
    {

        (new UserMailer())->userRegister(
            $user,
            '【知乎】欢迎注册知乎',
            'register@gooin.win');
//        // 模板变量
//        $data = [
//            'url' => route('email.verify', ['token' => $user->confirmation_token]),
//            'name' => $user->name
//        ];
//        $template = new SendCloudTemplate('zhihu_register',$data);
//
//        Mail::raw($template, function ($message) use ($user) {
//            $message->from('register@gooin.win', 'Laravel知乎注册');
//            $message->to($user->email);
//        });
    }
}
