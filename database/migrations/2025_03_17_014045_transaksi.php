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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenant')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('event')->onDelete('cascade');
            $table->foreignId('referral_staff_id')->nullable()->constrained('staff')->onDelete('set null');
            $table->string('papan_nama');
            $table->string('nama_pemesan');
            $table->decimal('watt_listrik');
            $table->string('listrik_24_jam');
            $table->string('bukti_transaksi');
            $table->decimal('total_price', 15, 2);
            $table->enum('status', ['Not Paid', 'Pending', 'Cancel', 'Successful', 'Rejected', 'Refund']);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
