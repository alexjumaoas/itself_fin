<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transfered__requests', function (Blueprint $table) {
            $table->id();
            $table->string("request_code")->nullable();
            $table->integer('job_request_id')->nullable();
            $table->integer('transfer_from')->nullable();
            $table->integer('transfer_to')->nullable();
            $table->string('remarks')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfered__requests');
    }
};
