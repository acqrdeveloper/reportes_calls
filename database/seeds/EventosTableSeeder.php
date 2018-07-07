<?php

use Illuminate\Database\Seeder;

class EventosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('eventos')->insert(array('id' => '1','name'  => 'ACD',                     'estado_call_id'  => '1',  'estado_visible_id' => '1', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '2','name'  => 'Break',                   'estado_call_id'  => '2',  'estado_visible_id' => '1', 'eventos_auxiliares' => '1', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '3','name'  => 'SS.HH',                   'estado_call_id'  => '2',  'estado_visible_id' => '1', 'eventos_auxiliares' => '1', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '4','name'  => 'Refrigerio',              'estado_call_id'  => '2',  'estado_visible_id' => '1', 'eventos_auxiliares' => '1', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '5','name'  => 'Feedback',                'estado_call_id'  => '2',  'estado_visible_id' => '1', 'eventos_auxiliares' => '1', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '6','name'  => 'Capacitación',            'estado_call_id'  => '2',  'estado_visible_id' => '1', 'eventos_auxiliares' => '1', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '7','name'  => 'Gestión BackOffice',      'estado_call_id'  => '2',  'estado_visible_id' => '1', 'eventos_auxiliares' => '1', 'cosapi_eventos' => '1', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '8','name'  => 'Inbound',                 'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '1', 'claro_eventos' => '1', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '9','name'  => 'OutBound',                'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '1', 'claro_eventos' => '1', 'estado_id' => '1', 'icon' => null, 'color' => null ));

        \DB::table('eventos')->insert(array('id' => '10','name' => 'ACW',                     'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '1', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '11','name' => 'Login',                   'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '12','name' => 'Ring-Inbound',            'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '13','name' => 'Ring-Outbound',           'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '14','name' => 'Estado D',                'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '15','name' => 'Desconectado',            'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '16','name' => 'Hold Inbound',  	        'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '17','name' => 'Hold Outbound',  	        'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '18','name' => 'Ring Inbound Interno',    'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '19','name' => 'Inbound Interno',  	      'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '20','name' => 'Outbound Interno',  	    'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '21','name' => 'Ring Outbound Interno',   'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '22','name' => 'Hold Inbound Interno',    'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '23','name' => 'Hold Outbound Interno',   'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '24','name' => 'Ring Inbound Transfer',   'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '25','name' => 'Inbound Transfer',  	    'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '26','name' => 'Hold Inbound Transfer',   'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '27','name' => 'Ring Outbound Transfer',  'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '28','name' => 'Hold Outbound Transfer',  'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));
        \DB::table('eventos')->insert(array('id' => '29','name' => 'Outbound Transfer',  	    'estado_call_id'  => '2',  'estado_visible_id' => '2', 'eventos_auxiliares' => '0', 'cosapi_eventos' => '0', 'claro_eventos' => '0', 'estado_id' => '1', 'icon' => null, 'color' => null ));

    }
}
