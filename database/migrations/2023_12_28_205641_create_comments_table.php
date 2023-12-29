<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('author_id');
            $table->index('author_id', 'comments_author_id_idx');
            $table->foreign('author_id', 'comments_author_fk')
                ->on('users')
                ->references('id');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by', 'comments_updated_by_fk')
                ->on('users')
                ->references('id');

            $table->unsignedBigInteger('ticket_id');
            $table->foreign('ticket_id', 'comments_ticket_fk')
                ->on('tickets')
                ->references('id')
                ->onDelete('cascade');

            $table->text('body');

            $table->boolean('is_public')->default(true);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
