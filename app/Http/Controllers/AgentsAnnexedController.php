<?php

namespace Cosapi\Http\Controllers;

use Cosapi\Models\Anexo;
use Illuminate\Http\Request;

class AgentsAnnexedController extends CosapiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            return view('elements/agents_annexed/index');
        }
    }

    public function queryListAnexo(){
        $list_annexed = Anexo::select()
                            ->with('user')
                            ->where('estado_id','=',1)
                            ->get()
                            ->toArray();
        return $list_annexed;
    }

    public function getUserAnexo()
    {
        return $this->UserAnexo;
    }

    public function getListAnnexed(Request $request){
        $tabla_anexos = [];
        $indice = 0;
        $contador = 0;
        if ($request->ajax()){
            if($request->event) {
                $list_annexed = $this->queryListAnexo($request->event);
                foreach ($list_annexed as $key => $annexed) {
                    if($request->event == 'free'){
                        if ($annexed['user'] == null) {
                            if ($contador > 5) {
                                $contador = 0;
                                $indice++;
                            }
                            $list_annexed[$key]['image'] = 'phone-yellow.png';
                            $list_annexed[$key]['btn'] = 'btn';
                            $list_annexed[$key]['StatusAnexo'] = 'Anexo Libre';
                            $list_annexed[$key]['user']['id'] = '';
                            $list_annexed[$key]['user']['username'] = '';
                            $tabla_anexos[$indice][$contador] = $list_annexed[$key];
                            $contador++;
                        }
                    }else{
                        if($annexed['user']['role']){
                            if ($annexed['user']['role'] == $request->event) {
                                if ($contador > 5) {
                                    $contador = 0;
                                    $indice++;
                                }
                                $list_annexed[$key]['image'] = 'phone-green.png';
                                $list_annexed[$key]['btn'] = 'btn disabled';
                                if($this->UserRole == 'admin' or $this->UserRole == 'supervisor') $list_annexed[$key]['btn'] = 'btn';
                                $list_annexed[$key]['StatusAnexo'] = 'Conectado';
                                $tabla_anexos[$indice][$contador] = $list_annexed[$key];
                                $contador++;
                            }
                        }
                    }

                }
                return view('layout/recursos/annexed')->with(array('tabla_anexos' => $tabla_anexos));
            }
        }
    }
}
