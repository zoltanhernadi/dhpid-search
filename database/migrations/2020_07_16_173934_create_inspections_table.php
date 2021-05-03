<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('establishmentName');
            $table->string('referenceNum');
            $table->string('location');
            $table->string('province');
            $table->string('rating');
            $table->string('currentlyRegistered');
            $table->string('registrationNum');
            $table->string('activity');
            $table->date('inspectionStartDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspections');
    }
}
