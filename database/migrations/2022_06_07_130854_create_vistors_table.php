<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVistorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vistors', function (Blueprint $table) {
            $table->id();
            $table->string('vistor_name');
            $table->string('mobile')->nullable();
            $table->date('date');
            $table->enum('status',['import','export']);
            $table->enum('location',['internal','external']);
            $table->string('replay');
            $table->date('replay_date');
            $table->text('description')->nullable();
            // $table->foreignId('recepion_id');
            // $table->foreign('recepion_id')->references('id')->on('recepions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vistors');
    }
}
