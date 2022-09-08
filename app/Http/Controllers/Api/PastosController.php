<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Repositories\PastosRepository;
use App\Repositories\PastosPeriodoRepository;
use App\Http\Controllers\Api\BaseController as BaseController;

class PastosController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PastosRepository $pastosRepository,
        PastosPeriodoRepository $pastosPeriodoRepository
    )
    {
        $this->middleware('auth:sanctum');
        $this->pastosRepository = $pastosRepository;
        $this->pastosPeriodoRepository = $pastosPeriodoRepository;
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
                'pasto_tipo' => 'required'
            ]);
    
            if($validator->fails()){
                return $this->sendError('Error validation', $validator->errors());       
            }

            // Create
            $pasto = $this->pastosRepository->create([
                'PASTO_NOME' => $request->pasto_nome,
                'PASTO_TIPO' => $request->pasto_tipo
            ]);
            return $this->sendResponse($pasto->makeHidden(['created_at','updated_at']), 'Pasto Created.');
        }

        /**
         * Apagar Pasto
         */
        public function apagar(Request $request)
        {
            try {
                $pasto = $this->pastosRepository->find($request->id);
                // Tira o pasto da fazenda
                foreach ($pasto->fazendas as $key => $fazenda) {
                    $fazenda->update([
                        "PASTO_ID" => null
                    ]);
                }
                $pasto->delete();
                return $this->sendResponse($pasto, 'Pasto id: '.$request->id.' deleted.');
            } catch (\Throwable $th) {
                //throw $th;
                return $this->sendResponse($th->getMessage(), 'Erro delete Fazenda id '.$request->id);
            }
        }
    /**
     * Períodos
     */
        /**
         * Lista Períodos
         */
        public function listaPeriodos()
        {
            $pastos = $this->pastosPeriodoRepository->with('pasto')->all();
            return $this->sendResponse($pastos->makeHidden(['created_at','updated_at']), 'Get List Períodos.');
        }
        
        /**
         * Novo Período
         */
        public function novoPeriodo(Request $request)
        {
            /**
             * Validation
             */
            $validator = Validator::make($request->all(), [
                'pasto_periodo_nome' => 'required',
                'pasto_id' => 'required',
                'pasto_data_inicial' => 'required',
                'pasto_data_final' => 'required'
            ]);
    
            if($validator->fails()){
                return $this->sendError('Error validation', $validator->errors());       
            }

            // Create
            $periodo = $this->pastosPeriodoRepository->create([
                'PASTO_PERIODO_NOME' => $request->pasto_periodo_nome,
                'PASTO_ID' => $request->pasto_id,
                'PASTO_DATA_FINAL' => $request->pasto_data_final,
                'PASTO_DATA_INICIAL' => $request->pasto_data_inicial
            ]);
            return $this->sendResponse($periodo->makeHidden(['created_at','updated_at']), 'Pasto Created.');
        }

        /**
         * Apagar Períodos
         */
        public function apagarPeriodo(Request $request)
        {
            try {
                $periodo = $this->pastosPeriodoRepository->delete($request->id);
                return $this->sendResponse($periodo, 'Pasto id: '.$request->id.' deleted.');
            } catch (\Throwable $th) {
                //throw $th;
                return $this->sendError('Erro delete Fazenda id '.$request->id, $th->getMessage());
            }
        }
}
