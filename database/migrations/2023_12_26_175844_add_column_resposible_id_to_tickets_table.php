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

            $table->unsignedBigInteger('responsible_id')->nullable();
            $table->index('responsible_id', 'tickets_responsible_idx');
            $table->foreign('responsible_id', 'tickets_responsible_fk')
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
            $table->dropForeign('tickets_responsible_fk');
            $table->dropIndex('tickets_responsible_idx');
            $table->dropColumn('responsible_id');
        });
    }
};
