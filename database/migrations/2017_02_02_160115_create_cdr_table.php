<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCdrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cdr', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->dateTime('calldate')->default('0000-00-00 00:00:00');
            $table->string('clid', 80)->default('');
            $table->string('src', 80)->default('');
            $table->string('dst', 80)->default('');
            $table->string('dcontext', 80)->default('');
            $table->string('channel', 80)->default('');
            $table->string('dstchannel', 80)->default('');
            $table->string('lastapp', 80)->default('');
            $table->string('lastdata', 80)->default('');
            $table->unsignedInteger('duration')->default(0);
            $table->unsignedInteger('billsec')->default(0);
            $table->string('disposition', 45)->default('');
            $table->unsignedInteger('amaflags')->default(0);
            $table->string('accountcode', 20)->default('');
            $table->string('uniqueid', 32)->default('');
            $table->string('userfield')->default('');
            $table->string('peeraccount',20)->default('');
            $table->string('linkedid',32)->default('');
            $table->unsignedInteger('sequence')->default(0);
              
            $table->index(['src','disposition','lastdata','calldate'], 'Filtro_kpi_dashboard_outbound');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cdr');
    }
}
