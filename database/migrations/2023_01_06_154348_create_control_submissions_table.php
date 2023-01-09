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
        Schema::create('control_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('control_id')->constrained();
            $table->foreignId('organization_id')->constrained();
            $table->string('assignedTo');
            $table->string('riskLevel');
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
        Schema::dropIfExists('control_submissions');
    }
};
