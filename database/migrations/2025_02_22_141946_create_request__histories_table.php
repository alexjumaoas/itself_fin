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
        Schema::create('request__histories', function (Blueprint $table) {
            $table->id();
            $table->string('request_code')->nullable();
            $table->integer('userid')->nullable();
            $table->string('remarks')->nullable();
            $table->string('action')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('work_done')->nullable();
            $table->string('resolution_notes')->nullable();
            $table->datetime('completion_date')->nullable();
            $table->datetime('assigned_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request__histories');
    }
};
