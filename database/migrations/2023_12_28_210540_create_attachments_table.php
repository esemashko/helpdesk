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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by', 'attachments_created_by_fk')
                ->on('users')
                ->references('id');

            $table->unsignedBigInteger('comment_id');
            $table->foreign('comment_id', 'attachments_comment_fk')
                ->on('comments')
                ->references('id');

            $table->string('file_name');

            $table->string('file_path');

            $table->string('file_type');

            $table->string('file_size');

            $table->string('file_extension');

            $table->string('file_mime_type');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by', 'attachments_updated_by_fk')
                ->on('users')
                ->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
