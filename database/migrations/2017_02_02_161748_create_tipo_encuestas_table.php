<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('tipo_encuestas', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 60)->unique();
            $table->unsignedTinyInteger('estado_id');
            $table->timestamps();

            /*fk tipo encuesta*/
            $table->foreign('estado_id')
                  ->references('id')
                  ->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tipo_encuestas');
    }
}
