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
            //
            $table->unsignedBigInteger('staff_id')->after('email');
            $table->string('role')->after('staff_id')->default('user');
            $table->softDeletes()->after('password');

            $table->foreign('staff_id')
                ->references('id')
                ->on('staff')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropForeign('users_staff_id_foreign');
            $table->dropColumn('staff_id');
            $table->dropColumn('role');
            $table->dropSoftDeletes();
        });
    }
};
