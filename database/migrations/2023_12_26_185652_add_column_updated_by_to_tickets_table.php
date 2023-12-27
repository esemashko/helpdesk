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
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->index('updated_by', 'tickets_updated_by_idx');
            $table->foreign('updated_by', 'tickets_updated_by_fk')
                ->on('users')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_updated_by_fk');
            $table->dropIndex('tickets_updated_by_idx');
            $table->dropColumn('updated_by');
        });
    }
};
