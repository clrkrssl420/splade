<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->index(['lead_status_id', 'user_id']);

            $table->index(['user_id', 'deleted_at']);

            $table->index(['lead_status_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropIndex(['lead_status_id', 'user_id']);
            $table->dropIndex(['user_id', 'deleted_at']);
            $table->dropIndex(['lead_status_id', 'deleted_at']);
        });
    }
};
