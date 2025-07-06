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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name', 100);
            $table->string('institution_name', 100);
            $table->string('phone', 15);
            $table->text('address');
            $table->string('account_number', 50);
            $table->string('education', 50);
            $table->integer('tenor');
            $table->decimal('amount', 12, 2)->comment('Jumlah pinjaman');
            $table->decimal('interest_rate', 12, 2)->comment('Bunga per tahun');
            $table->decimal('independent_responsibility', 12, 2)->comment('Tanggungan mandiri');
            $table->decimal('admin_fee', 5, 2)->comment('Biaya admin');
            $table->date('start_date')->nullable()->comment('Tanggal pencairan');
            $table->date('end_date')->nullable()->comment('Tanggal jatuh tempo akhir');
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'paid'])->default('draft');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
