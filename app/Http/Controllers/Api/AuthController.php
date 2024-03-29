<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PastosRepository;
use App\Repositories\FazendasRepository;
use App\Repositories\PastosPeriodoRepository;
use App\Repositories\FazendasPiquetesRepository;
use App\Http\Controllers\Api\BaseController as BaseController;

class AuthController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PastosRepository $pastosRepository,
        FazendasRepository $fazendasRepository,
        PastosPeriodoRepository $pastosPeriodoRepository,
        FazendasPiquetesRepository $fazendasPiquetesRepository
    )
    {
        $this->pastosRepository = $pastosRepository;
        $this->fazendasRepository = $fazendasRepository;
        $this->pastosPeriodoRepository = $pastosPeriodoRepository;
        $this->fazendasPiquetesRepository = $fazendasPiquetesRepository;
    }

    public function signin(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $authUser = Auth::user(); 
            $success['token'] =  $authUser->createToken('manejo')->plainTextToken; 
            $success['name'] =  $authUser->name;
   
            return $this->sendResponse($success, 'User signed in');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['type'] = 1;
        $user = User::create($input);
        $success['token'] =  $user->createToken('manejo')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User created successfully.');
    }

    public function me()
    {
        return $this->sendResponse(auth()->user()->makeHidden(['id','email_verified_at','type','created_at','updated_at']),'Get User.');
    }

    public function info()
    {
        /**
         * Verifica se está dentro do prazo
         */
        $periodos = $this->pastosPeriodoRepository->all();
        $alertas = [];
        foreach ($periodos as $key => $periodo) {
            if (
                time() >= strtotime($periodo->PASTO_DATA_FINAL.' -3 days') &&
                time() <= strtotime($periodo->PASTO_DATA_FINAL)
            ) {
                array_push($alertas,$periodo);
            }
        }
        /**
         * Array de Retorno
         */
        $array = [
            "pastos" => $this->pastosRepository->count(),
            "periodos" => $this->pastosPeriodoRepository->count(),
            "fazendas"=>[
                "count" => $this->fazendasRepository->count(),
                "piquetes" => $this->fazendasPiquetesRepository->count()
            ],
            "alertas" => $alertas
        ];
        return $this->sendResponse($array,'Get Info.');
    }
}
