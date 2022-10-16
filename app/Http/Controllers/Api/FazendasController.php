<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Repositories\FazendasRepository;
use App\Repositories\PiquetesHistoryRepository;
use App\Repositories\FazendasPiquetesRepository;
use App\Http\Controllers\Api\BaseController as BaseController;

class FazendasController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        FazendasRepository $fazendasRepository,
        PiquetesHistoryRepository $piquetesHistoryRepository,
        FazendasPiquetesRepository $fazendasPiquetesRepository
    )
    {
        $this->middleware('auth:sanctum');
        $this->fazendasRepository = $fazendasRepository;
        $this->piquetesHistoryRepository = $piquetesHistoryRepository;
        $this->fazendasPiquetesRepository = $fazendasPiquetesRepository;
    }

    /**
     * Fazenda
     */
        /**
         * Lista Fazenda
         */
        public function lista()
        {
            try {
                $fazendas = $this->fazendasRepository->with(['piquetes'=>function($q){
                    return $q->select(['FAZENDA_ID',
                    'PIQUETE_INDEX',
                    'PIQUETE_DESCRICAO',
                    'PIQUETE_OCUPADO',
                    'PIQUETE_ULTIMA_DESOCUPACAO',
                    'PIQUETE_ULTIMA_OCUPACAO']);
                },'pasto'])->all();
                return $this->sendResponse($fazendas->makeHidden(['created_at','updated_at']), 'Get List Fazendas.');
            } catch (\Throwable $th) {
                //throw $th;
                return $this->sendResponse($th->getMessage(), 'Erro delete Fazenda id '.$request->id);
            }
        }

        /**
         * Criar Fazenda
         */
        public function novo(Request $request)
        {
            try {
                $fazenda = $this->fazendasRepository->create([
                    'FAZENDA_NOME' => $request->fazenda_nome,
                    'PASTO_ID' => $request->pasto_id
                ]);
                for ($i=1; $i <= $request->piquetes_qnt; $i++) { 
                    $this->fazendasPiquetesRepository->create([
                        'FAZENDA_ID' => $fazenda->id,
                        'PIQUETE_INDEX' => $i,
                        'PIQUETE_OCUPADO' => false
                    ]);
                }
                $fazenda = $this->fazendasRepository->with(['piquetes'=>function($q){
                    return $q->select(['FAZENDA_ID',
                    'PIQUETE_INDEX',
                    'PIQUETE_DESCRICAO',
                    'PIQUETE_OCUPADO',
                    'PIQUETE_ULTIMA_DESOCUPACAO',
                    'PIQUETE_ULTIMA_OCUPACAO']);
                }])->find($fazenda->id);
                return $this->sendResponse($fazenda->makeHidden(['created_at','updated_at']), 'Created Fazenda '.$request->fazenda_nome);
            } catch (\Throwable $th) {
                //throw $th;
                return $this->sendResponse($th->getMessage(), 'Erro delete Fazenda id '.$request->id);
            }
        }

        /**
         * Atualizar Fazenda
         */
        public function atualiza(Request $request, $id)
        {
            $fazenda = $this->fazendasRepository->find($id);
            if ($request->piquetes_qnt != $fazenda->piquetes->count()) {
                if ($request->piquetes_qnt > $fazenda->piquetes->count()) {
                    # if maior
                    $qntParaAdicionar = $request->piquetes_qnt - $fazenda->piquetes->count();
                    for ($i=1; $i <= $qntParaAdicionar; $i++) { 
                        $this->fazendasPiquetesRepository->create([
                            'FAZENDA_ID' => $fazenda->id,
                            'PIQUETE_INDEX' => $fazenda->piquetes->count() + $i,
                            'PIQUETE_OCUPADO' => false
                        ]);
                    }
                }else {
                    # if menor
                    $qntParaRemover = $fazenda->piquetes->count() - $request->piquetes_qnt;
                    $index = 0;
                    foreach ($fazenda->piquetes->sortByDesc('PIQUETE_INDEX') as $key => $piquete) {
                        if ($qntParaRemover != $index) {
                            $piquete->delete();
                            $index++;
                        }
                    }
                }
            }
            $fazenda->update([
                'FAZENDA_NOME' => $request->fazenda_nome,
                'PASTO_ID' => $request->pasto_id
            ]);
            $fazenda = $this->fazendasRepository->with(['piquetes'=>function($q){
                return $q->select(['FAZENDA_ID',
                'PIQUETE_INDEX',
                'PIQUETE_DESCRICAO',
                'PIQUETE_OCUPADO',
                'PIQUETE_ULTIMA_DESOCUPACAO',
                'PIQUETE_ULTIMA_OCUPACAO']);
            }])->find($fazenda->id);
            return $this->sendResponse($fazenda->makeHidden(['created_at','updated_at']), 'Fazenda updated '.$request->fazenda_nome);
        }

        /**
         * Apagar Fazenda
         */
        public function apagar(Request $request)
        {
            try {
                $fazenda = $this->fazendasRepository->delete($request->id);
                return $this->sendResponse($fazenda, 'Deleted Fazenda id '.$request->id);
            } catch (\Throwable $th) {
                //throw $th;
                return $this->sendResponse($th->getMessage(), 'Erro delete Fazenda id '.$request->id);
            }
        }

    /**
     * Piquetes
     */
        public function addPiquete($idFazenda)
        {
            $piquete = $this->fazendasPiquetesRepository->findWhere(['FAZENDA_ID' => $idFazenda])->sortByDesc('PIQUETE_INDEX')->first();
            if ($piquete == null) {
                // Se não tiver piquete adicionar o primerio
                $this->fazendasPiquetesRepository->create([
                    'FAZENDA_ID' => $idFazenda,
                    'PIQUETE_INDEX' => 1,
                    'PIQUETE_OCUPADO' => false
                ]);
            }else {
                // Se já tiver adicionar no lugar do último
                $this->fazendasPiquetesRepository->create([
                    'FAZENDA_ID' => $idFazenda,
                    'PIQUETE_INDEX' => $piquete->PIQUETE_INDEX + 1,
                    'PIQUETE_OCUPADO' => false
                ]);
            }
            $fazenda = $this->fazendasRepository->with(['piquetes'=>function($q){
                return $q->select(['FAZENDA_ID',
                'PIQUETE_INDEX',
                'PIQUETE_DESCRICAO',
                'PIQUETE_OCUPADO',
                'PIQUETE_ULTIMA_DESOCUPACAO',
                'PIQUETE_ULTIMA_OCUPACAO']);
            }])->find($idFazenda);
            return $this->sendResponse($fazenda->makeHidden(['created_at','updated_at']), 'Piquete adedded to Fazenda '.$fazenda->FAZENDA_NOME);
        }

        public function removePiquete(Request $request, $idFazenda)
        {
            $piqueteDeleted = $this->fazendasPiquetesRepository->deleteWhere(['FAZENDA_ID' => $idFazenda,'PIQUETE_INDEX' => $request->index]);
            $piquetes = $this->fazendasPiquetesRepository->findWhere(['FAZENDA_ID' => $idFazenda])->sortBy('PIQUETE_INDEX');
            $novaOrdenacao = [];
            $order=1;
            // Apaga o indez
            foreach ($piquetes as $piquete) {
                if ($piquete->PIQUETE_INDEX != $order) {
                    $piquete->update(["PIQUETE_INDEX" => $order]);
                }
                $order++;
            }
            $fazenda = $this->fazendasRepository->with(['piquetes'=>function($q){
                return $q->select(['FAZENDA_ID',
                'PIQUETE_INDEX',
                'PIQUETE_DESCRICAO',
                'PIQUETE_OCUPADO',
                'PIQUETE_ULTIMA_DESOCUPACAO',
                'PIQUETE_ULTIMA_OCUPACAO']);
            }])->find($idFazenda);
            return $this->sendResponse($fazenda->makeHidden(['created_at','updated_at']), 'Piquete removed to Fazenda '.$fazenda->FAZENDA_NOME);
        }

        public function historyPiquete(Request $request, $idFazenda)
        {
            $piquetes = $this->fazendasPiquetesRepository->findWhere(['FAZENDA_ID' => $idFazenda,'PIQUETE_INDEX' => $request->index]);
            if ($piquetes->count() == 0) {
                # code...
                // Error
            }
            $history = $this->piquetesHistoryRepository->with(['user','piquete'])->findWhere([
                'PIQUETE_ID' => $piquetes->first()->id
            ]);
            return $this->sendResponse($history, 'Get Piquete hitory.');
        }

        public function atualizaPiquete(Request $request, $idFazenda)
        {
            // date_default_timezone_set('America/Belem');
            $piquetes = $this->fazendasPiquetesRepository->findWhere(['FAZENDA_ID' => $idFazenda,'PIQUETE_INDEX' => $request->index]);
            if ($piquetes->count() == 0) {
                # code...
                // Error
            }
            $piquetes->first()->update([
                "PIQUETE_OCUPADO" => ($request->ocupado)?1:0,
            ]);
            if ($request->ocupado) {
                $this->piquetesHistoryRepository->create([
                    'PIQUETE_ID' => $piquetes->first()->id,
                    'PIQUETE_OP' => 0,
                    'PIQUETE_TIME' => now(),
                    'USER_ID' => auth()->user()->id
                ]);
                $piquetes->first()->update([
                    "PIQUETE_ULTIMA_OCUPACAO" => now(),
                ]);
            }else{
                $this->piquetesHistoryRepository->create([
                    'PIQUETE_ID' => $piquetes->first()->id,
                    'PIQUETE_OP' => 1,
                    'PIQUETE_TIME' => now(),
                    'USER_ID' => auth()->user()->id
                ]);
                $piquetes->first()->update([
                    "PIQUETE_ULTIMA_DESOCUPACAO" => now(),
                ]);
            }
            return $this->sendResponse($piquetes->first()->makeHidden(['id','created_at','updated_at']), 'Piquete updated ');
        }
}
