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
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('priority_id');
            $table->index('priority_id', 'priority_idx');
            $table->foreign('priority_id', 'priority_fk')
                ->on('priorities')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('priority_fk');
            $table->dropIndex('priority_idx');
            $table->dropColumn('priority_id');
        });
    }
};
