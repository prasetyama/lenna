<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_entry', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('url', 225);
            $table->string('method', 50);
            $table->text('body');
            $table->text('header');
            $table->string('ip', 150);
            $table->string('response_code', 150);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_entry');
    }
}
