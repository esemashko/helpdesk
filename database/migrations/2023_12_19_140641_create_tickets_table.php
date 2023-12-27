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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description')->nullable();
            $table->uuid('guid')->unique();

            $table->softDeletes();
            $table->timestamps();
            $table->timestamp('status_updated_at')->nullable();
            $table->timestamp('resolution_deadline')->nullable();
            $table->timestamp('response_date')->nullable();
            $table->timestamp('first_response')->nullable();
            $table->timestamp('closed_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
