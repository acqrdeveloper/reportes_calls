<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $myTable = 'estados';
      \DB::table($myTable)->insert(array('id'  =>  '1', 'name'  =>  'Activo',   'created_at' => Carbon::now(), 'updated_at' => Carbon::now()   ));
      \DB::table($myTable)->insert(array('id'  =>  '2', 'name'  =>  'Inactivo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()  ));
    }
}
