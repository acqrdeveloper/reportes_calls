<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('eventos', function (Blueprint $table){
             $table->increments('id')->unsigned();
             $table->string('name',255)->unique();

             $table->unsignedInteger('estado_call_id');
             $table->unsignedInteger('estado_visible_id');
             $table->unsignedInteger('eventos_auxiliares');
             $table->unsignedInteger('cosapi_eventos');
             $table->unsignedInteger('claro_eventos');
             $table->unsignedTinyInteger('estado_id');
             $table->string('icon',50)->nullable();
             $table->string('color',50)->nullable();
             $table->timestamps();

             /*creando las relaciones de las llaves foraneas*/
             $table->foreign('estado_id')
                ->references('id')
                ->on('estados');

              $table->foreign('estado_call_id')
                ->references('id')
                ->on('estados_calls');

              $table->foreign('estado_visible_id')
                ->references('id')
                ->on('estados_visibles');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('eventos');
    }
}
