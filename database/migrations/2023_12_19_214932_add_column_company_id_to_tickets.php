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
            $table->unsignedBigInteger('company_id');
            $table->index('company_id', 'company_idx');
            $table->foreign('company_id', 'company_fk')
                ->on('companies')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('company_fk');
            $table->dropIndex('company_idx');
            $table->dropColumn('company_id');
        });
    }
};
