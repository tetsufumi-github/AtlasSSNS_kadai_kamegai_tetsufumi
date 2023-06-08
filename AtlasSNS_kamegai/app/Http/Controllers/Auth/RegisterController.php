<?php



namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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
    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $username = $request->input('username');
            $mail = $request->input('mail');
            $password = $request->input('password');

            $this->validate($request, [
                'password' => ['required', 'string', 'min:8', 'max:20', 'regex:/^[0-9a-zA-Z]+$/'],
            ]);

            User::create([
                'username' => $username,
                'mail' => $mail,
                'password' => bcrypt($request->input('password')),
            ]);

            // ユーザー名をセッションに保存
            $request->session()->put('username', $username);

            return redirect('added');
        }

        return view('auth.register');
    }



    public function added(Request $request)
    {
        // セッションからユーザー名を取得
        $username = $request->session()->get('username');

        return view('auth.added', ['username' => $username]);
    }
}
