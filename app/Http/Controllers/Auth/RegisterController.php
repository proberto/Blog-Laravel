<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
        $messages = [
            'required' => '*Campo obrigatório',
            'email' => 'Insira um email válido',
            'email.confirmed' => 'Email não confere',
            'email.unique' => 'Email já foi cadastrado. Utilize outro email',
            'password.confirmed' => 'Senha não confere',
            'password.min' => 'A senha deve conter no mínimo 6 caracteres'
        ];
        

        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users|confirmed',
            'password' => 'required|min:6|confirmed',
            'cnpj-cpf' => 'required',
            'cep' => 'required', 
            'logradouro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',
            'numero' => 'required',
            'ddd' => 'required',
            'fone' => 'required',
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {         
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'cnpj-cpf' => $data['cnpj-cpf'],
            'cep' => $data['cep'],
            'logradouro' => $data['logradouro'],
            'cidade' => $data['cidade'], 
            'uf' => $data['uf'],
            'numero' => $data['numero'],
            'complemento' => $data['complemento'],
            'ddd' => $data['ddd'],
            'fone' => $data['fone'],
            'whats' => $data['whats'],
        ]);
    }

    /*
     * from: https://laracasts.com/discuss/channels/laravel/redirect-after-registration-like-login?page=0
     * Overrides the method to avoid auto-login after registration
     */   

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);
        //this commented to avoid register user being auto logged in

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
    
}
