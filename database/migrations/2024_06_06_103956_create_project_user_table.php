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
        Schema::create('project_user', function (Blueprint $table) {
            $table->foreignId('project_id');
            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_user', function (Blueprint $table) {
            $table->dropForeign(['project_id', 'user_id']);
        });

        Schema::dropIfExists('project_user');
    }
};
