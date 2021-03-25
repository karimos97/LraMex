<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAramexAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aramex_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('CountryCode',50)->nullable();
            $table->string('Ac_Entity',50)->nullable();
            $table->string('Ac_Number',150)->nullable();
            $table->string('Ac_Pin',150)->nullable();
            $table->string('UserName',150)->nullable();
            $table->string('Password',150)->nullable();
            $table->string('CCAB',150)->nullable();
            $table->integer('user_id');
            $table->timestamps();
            $table->softDeletes();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aramex_accounts');
    }
}
