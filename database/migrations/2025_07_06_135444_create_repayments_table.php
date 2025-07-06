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
        Schema::create('repayments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('loans');
            $table->integer('installment_number')->comment('Angsuran ke-berapa');
            $table->decimal('amount', 12, 2)->comment('Jumlah yang harus dibayar per cicilan');
            $table->date('due_date')->comment('Tanggal jatuh tempo cicilan');
            $table->date('paid_date')->nullable()->comment('Tanggal pembayaran ');
            $table->enum('status', ['pending', 'paid', 'late']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repayments');
    }
};
