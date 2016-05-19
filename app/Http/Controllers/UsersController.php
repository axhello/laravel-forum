<?php

namespace App\Http\Controllers;

use App\City\City;
use App\Comment;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SaveInfoRequest;
use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Laravist\GeeCaptcha\GeeCaptcha;
use Overtrue\Socialite\SocialiteManager;

class UsersController extends Controller
{
    protected $city;

    /**
     * UsersController constructor.
     */
    public function __construct(City $city)
    {
        $this->city = $city;
        $this->middleware('users', ['only' => ['profile', 'account', 'saveInfo', 'changeAvatar', 'cropAvatar']]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return view('users.register');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('users.login');
    }

    /**
     * @return mixed
     */
    public function captcha()
    {
        $captcha = new GeeCaptcha(env('CAPTCHA_ID'), env('PRIVATE_KEY'));
        return $captcha->GTServerIsNormal();
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(RegisterRequest $request)
    {
        $captcha = new GeeCaptcha(env('CAPTCHA_ID'), env('PRIVATE_KEY'));

        if ($captcha->isFromGTServer() && $captcha->success()) {
            $data = ['confirm_code' => str_random(48), 'avatar' => '/images/default-avatar.jpg'];
            $user = User::create(array_merge($request->all(), $data));
            $subject = 'Laravel社区邮件确认';
            $view = 'email.register';
            $this->sendTo($user, $subject, $view, $data);
            \Session::flash('register_success','注册成功!请验证邮箱后登录');
        }else {
            return redirect()->back()->withInput()->withErrors('captcha','验证码错误');
        }

        return redirect('/');
    }

    /**
     * @param $user
     * @param $subject
     * @param $view
     * @param array $data
     */
    private function sendTo($user, $subject, $view, $data = [])
    {
        \Mail::send($view, $data, function ($message) use ($user, $subject) {
            $message->to($user->email)->subject($subject);
        });
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signin(LoginRequest $request)
    {
        $remember = ($request->has('remember')) ? true : false;
        $user = \Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'is_confirmed' => 1
        ],$remember);
        if ($user) {
            return redirect('/');
        } else {
            \Session::flash('not_email', '邮箱没有通过验证或密码错误!');
            return redirect('/user/login')->withInput();
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        \Auth::logout();
        return redirect('/');
    }

    /**
     * @return mixed
     */
    public function redirectToProvider()
    {
        $socialite = new SocialiteManager(config('services'));
        return $socialite->driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     * @return \Response
     */
    public function handleProviderCallback()
    {
        try {
            $socialite = new SocialiteManager(config('services'));
            $user = $socialite->driver('github')->user();
        } catch (\Exception $e) {
            return redirect('/auth/github');
        }

        $gitUser = $this->findOrCreateUser($user);
        \Auth::login($gitUser, true);
        return redirect('/');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = \Auth::user();
        $comments = Comment::with('discussions')->where('user_id', '=', $user->id)->paginate(10);
        return view('users.profile', compact('comments', 'user'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function account()
    {
        $user = \Auth::user();
        $cities = $this->city->city();
        return view('users.account', compact('user', 'cities'));
    }

    /**
     * @param User $user
     * @return \View
     */
    public function information(User $user)
    {
        $comments = Comment::with('discussions')->where('user_id', '=', $user->id)->paginate(10);
        return view('users.information', compact('user', 'comments'));
    }

    /**
     * @param SaveInfoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveInfo(SaveInfoRequest $request)
    {
        $user = \Auth::user();
        $user->nickname = $request->get('nickname');
        $user->weibo = $request->get('weibo');
        $user->github = $request->get('github');
        $user->blog = $request->get('blog');
        $user->city = $request->get('city');
        $user->desc = $request->get('desc');
        $user->save();
        return redirect('/user/profile');
    }

    /**
     * @param $confirm_code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmEmail($confirm_code)
    {
        $user = User::where('confirm_code', $confirm_code)->first();
        if (is_null($user)) {
            return redirect('/');
        }
        $user->is_confirmed = 1;
        $user->confirm_code = str_random(48);
        $user->save();
        \Session::flash('email_confirm', '您的邮箱已通过确认!');
        return redirect('/user/login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeAvatar(Request $request)
    {
        $file = $request->file('avatar');
        $input = array('image' => $file);
        $rules = array('image' => 'image',);
        $validator = \Validator::make($input, $rules);
        if ($validator->fails()) {
            return \Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
        }
        $destinationPath = 'images/';
        $filename = \Auth::user()->id . '_' . time() . '_' . $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        Image::make($destinationPath . $filename)->fit(400)->save();

        return \Response::json(['success' => true, 'avatar' => asset($destinationPath . $filename), 'image' => $destinationPath . $filename, ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cropAvatar(Request $request)
    {
        $photo = $request->get('photo');
        $width = (int)$request->get('w');
        $height = (int)$request->get('h');
        $xAlign = (int)$request->get('x');
        $yAlign = (int)$request->get('y');
        Image::make($photo)->crop($width, $height, $xAlign, $yAlign)->save();

        $user = \Auth::user();
        $user->avatar = asset($photo);
        $user->save();

        return redirect('/user/account');
    }

    /**
     * Return user if exists; create and return if doesn't
     * @param $githubUser
     * @return User
     */
    private function findOrCreateUser($githubUser)
    {
        if ($authUser = User::where('email', $githubUser->getEmail())->first()) {
            return $authUser;
        }
        return User::create([
            'name' => $githubUser->getNickname(),
            'avatar' => $githubUser->getAvatar(),
            'confirm_code' => str_random(48),
            'email' => $githubUser->getEmail(),
            'password' => bcrypt(str_random(16)),
            'blog' => $githubUser->getOriginal()['blog'],
            'github' => $githubUser->getOriginal()['html_url'],
            'is_confirmed' => 1
        ]);
    }

}
