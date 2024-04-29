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
        Schema::create('education', function (Blueprint $table) {
          $table->id();
           $table->text('typeofeducation');
           $table->boolean('clothes')->default(false);
           $table->boolean('booksandpens')->default(false);
           $table->boolean('courses')->default(false);
           $table->boolean('bags')->default(false);
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
        Schema::dropIfExists('education');
    }
};
