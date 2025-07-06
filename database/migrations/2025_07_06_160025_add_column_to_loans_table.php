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
        Schema::table('loans', function (Blueprint $table) {
            $table->renameColumn('interest_rate', 'annual_interest_rate');
            $table->decimal('monthly_interest_rate', 5, 4)->default(0.0029)->after('annual_interest_rate');
            $table->decimal('monthly_payment', 12, 2)->nullable()->after('amount')->comment('cicilan bulanan');
            $table->decimal('total_amount', 12, 2)->after('admin_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->renameColumn('annual_interest_rate', 'interest_rate');
            $table->dropColumn('monthly_interest_rate');
            $table->dropColumn('monthly_payment');
            $table->dropColumn('total_amount');
        });
    }
};
