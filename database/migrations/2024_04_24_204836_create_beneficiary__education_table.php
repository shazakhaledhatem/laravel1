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
        Schema::create('beneficiary__education', function (Blueprint $table) {
          $table->id();
           $table->unsignedBigInteger('beneficiaries_id');
           $table->unsignedBigInteger('education_id');
           $table->unsignedBigInteger('charities_id')->nullable();
           $table->enum('status', ['pending', 'approved', 'rejected', 'in_process', 'completed'])->default('pending');
           $table->boolean('active')->default(false);
           $table->timestamps();

           $table->foreign('beneficiaries_id')->references('id')->on('beneficiaries')->onDelete('cascade');
           $table->foreign('education_id')->references('id')->on('education')->onDelete('cascade');
           $table->foreign('charities_id')->references('id')->on('charities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficiary__education');
    }
};
