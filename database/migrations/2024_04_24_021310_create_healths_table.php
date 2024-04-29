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
        Schema::create('healths', function (Blueprint $table) {
          $table->id();
     $table->text('typeofdisease');
     $table->boolean('operation')->default(false);
     $table->boolean('doctorcheck')->default(false);
     $table->boolean('medicine')->default(false);
     $table->boolean('medicaldevice')->default(false);
     $table->text('typeofdevice');
     $table->boolean('milkanddiaper')->default(false);
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
        Schema::dropIfExists('healths');
    }
};
