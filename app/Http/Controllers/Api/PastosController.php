<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Repositories\PastosRepository;
use App\Http\Controllers\Api\BaseController as BaseController;

class PastosController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PastosRepository $pastosRepository
    )
    {
        $this->middleware('auth:sanctum');
        $this->pastosRepository = $pastosRepository;
    }

    /**
     * Pastos
     */

        /**
         * Lista Pastos
         */
        public function lista()
        {
            $pastos = $this->pastosRepository->all();
            return $this->sendResponse($pastos->makeHidden(['created_at','updated_at']), 'Get List Pastos.');
        }
        
        /**
         * Novo Pasto
         */
        public function novo(Request $request)
        {
            /**
             * Validation
             */
            $validator = Validator::make($request->all(), [
                'pasto_nome' => 'required',
                'pasto_data_inicial' => 'required',
                'pasto_data_final' => 'required',
            ]);
    
            if($validator->fails()){
                return $this->sendError('Error validation', $validator->errors());       
            }

            // Create
            $pasto = $this->pastosRepository->create([
                'PASTO_NOME' => $request->pasto_nome,
                'PASTO_DATA_INICIAL' => $request->pasto_data_inicial,
                'PASTO_DATA_FINAL' => $request->pasto_data_final,
                'PASTO_DESCRICAO' => $request->pasto_descricao
            ]);
            return $this->sendResponse($pasto->makeHidden(['created_at','updated_at']), 'Pasto Created.');
        }

        /**
         * Apagar Pasto
         */
        public function apagar(Request $request)
        {
            try {
                $pasto = $this->pastosRepository->delete($request->id);
                return $this->sendResponse($pasto, 'Pasto id: '.$request->id.' deleted.');
            } catch (\Throwable $th) {
                //throw $th;
                return $this->sendResponse($th->getMessage(), 'Erro delete Fazenda id '.$request->id);
            }
        }
}
