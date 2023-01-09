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
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('report');
            $table->string('rootCause');
            $table->string('correctiveAction');
            $table->date('startTime');
            $table->date('endTime');
            $table->bigInteger('nbCaliforniaIndividualsAffected');
            $table->string('contactFirstName');
            $table->string('contactLastName');
            $table->string('contactPhone');
            $table->string('contactEmail');
            $table->string('contactTitle');
            $table->foreignId('organization_id')->constrained();
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('incident_reports');
    }
};
