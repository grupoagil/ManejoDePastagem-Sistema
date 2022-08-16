<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }


    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $users = $model->get();
        return view('users.index', compact('users'));
    }

    /**
     * Função para criar novo usuário
     */
    public function create(Request $request)
    {
        /**
         * Valida
         */
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if($validator->fails()){
            return redirect()->back()
            ->with('error','Verifique os campos e tente novamente')
            ->withInput();
        }
        /**
         * Cria o usuário
         */
        $request['password'] = Hash::make($request['password']);
        $request['type'] = 0; // Tipo admin
        $this->user->create($request->all());
        return redirect()->back()->with('success','Usuário criado com sucesso!');
    }

    /**
     * Função para atualizar novo usuário
     */
    public function update(Request $request,$id)
    {
        $user = $this->user->find($id);
        if(isset($request->password) && isset($request->password_confirmation)){
            // Se tiver senha
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            if($validator->fails()){
                return redirect()->back()
                ->with('error','Verifique os campos e tente novamente')
                ->withInput();
            }
            $request['password'] = Hash::make($request['password']);
            $user->update($request->all());
        }else{
            // Se não tiver senha
            $request = $request->except(['_token','password','password_confirmation']);
            $user->update($request);
        }
        return redirect()->back()->with('success','Usuário atualizado com sucesso!');
    }

    /**
     * Apagar usuário
     */
    public function apagar($id)
    {
        $this->user->find($id)->delete();
        return redirect()->back()->with('success','Usuário apagado com sucesso!');
    }
}
