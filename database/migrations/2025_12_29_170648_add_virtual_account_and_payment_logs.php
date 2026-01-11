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
        // Add virtual_account_number to santri table
        Schema::table('santri', function (Blueprint $table) {
            $table->string('virtual_account_number')->nullable()->unique()->after('nis')->comment('VA Permanen untuk pembayaran (e.g. Midtrans)');
        });

        // Create payment_gateway logs table
        Schema::create('payment_gateway', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique()->comment('Order ID dari sistem kita atau Midtrans');
            $table->string('payment_type')->nullable()->comment('Tipe pembayaran: bank_transfer, gopay, dll');
            $table->string('transaction_status')->comment('Status: pending, settlement, expire, cancel');
            $table->decimal('gross_amount', 15, 2)->comment('Jumlah pembayaran');
            $table->json('json_response')->nullable()->comment('Raw response dari Midtrans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->dropColumn('virtual_account_number');
        });

        Schema::dropIfExists('payment_gateway');
    }
};
