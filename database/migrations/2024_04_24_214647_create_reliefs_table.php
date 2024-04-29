<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reliefs', function (Blueprint $table) {
          $table->id();
         $table->boolean('home')->default(false);
         $table->boolean('housefurniture')->default(false);
         $table->boolean('food')->default(false);
         $table->boolean('clothes')->default(false);
         $table->boolean('money')->default(false);
         $table->boolean('psychologicalaid')->default(false);
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
        Schema::dropIfExists('reliefs');
    }
};
