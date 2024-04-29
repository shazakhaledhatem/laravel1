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
        Schema::create('life_hoods', function (Blueprint $table) {
          $table->id();
            $table->boolean('learningaprofession')->default(false);
            $table->boolean('gainmoreexperienceinspecificfield')->default(false);
            $table->text('typeofworkthatyouwanttogain');
            $table->boolean('jobapportunity')->default(false);
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
        Schema::dropIfExists('life_hoods');
    }
};
