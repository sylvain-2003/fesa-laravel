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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nif')->nullable()->unique()->after('type_membre');
            $table->string('type_piece')->nullable()->after('nif');
            $table->string('numero_piece')->nullable()->after('type_piece');
            $table->unique(['type_piece', 'numero_piece']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['type_piece', 'numero_piece']);
            $table->dropUnique(['nif']);
            $table->dropColumn(['nif', 'type_piece', 'numero_piece']);
        });
    }
};
