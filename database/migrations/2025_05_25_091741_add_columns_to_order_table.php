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
        Schema::table('order', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id')->nullable()->after('customer_id');
            $table->unsignedBigInteger('branch_id')->nullable()->after('user_id');
            $table->string('status')->default('pending')->after('total_amount');
            $table->string('payment_status')->default('unpaid')->after('status');
            $table->text('remark')->nullable()->after('payment_status');

            // ✅ Correct foreign key reference to users(id)
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('branch_id')
                ->references('id')
                ->on('branch')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['branch_id']);
            $table->dropColumn(['user_id', 'branch_id', 'status', 'payment_status', 'remark']);
        });
    }
};
