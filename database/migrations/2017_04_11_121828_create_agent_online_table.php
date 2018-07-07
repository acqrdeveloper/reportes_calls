<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentOnlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_online', function (Blueprint $table)
        {
            $table->increments('id')->unsigned();
          	$table->unsignedTinyInteger('agent_user_id');
          	$table->string('agent_role',15)->nullable();
          	$table->string('agent_name',50);
          	$table->char('agent_annexed',4)->default('-');
          	$table->char('agent_status',1)->default(0);
          	$table->char('agent_penality',1)->default(1);
          	$table->unsignedTinyInteger('agent_total_calls')->default(0);
          	$table->char('event_id',2)->nullable();
          	$table->char('event_id_old',2)->nullable();
          	$table->string('event_name',35);
          	$table->string('event_observaciones',50)->nullable();
          	$table->string('event_time',15);
          	$table->string('inbound_queue',50)->nullable();
          	$table->string('inbound_phone',25)->nullable();
          	$table->string('inbound_start',15);
          	$table->string('outbound_phone',25)->nullable();
          	$table->string('outbound_start',15);
          	$table->string('timeElapsed',2);
          	$table->char('transfer',2)->nullable()->default(0);
          	$table->unsignedTinyInteger('status_call')->default(0);
          	$table->string('second_outbound_phone',25)->nullable();
          	$table->string('second_outbound_start',15);
          	$table->char('second_event_id',2)->nullable();
          	$table->string('second_event_name',35);

            $table->index(['agent_name'], 'Username_Unico');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::drop('agent_online');
    }
}
