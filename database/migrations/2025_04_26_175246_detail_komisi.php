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
        Schema::create('detail_komisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('komisi_id')->constrained('komisi')->onDelete('cascade'); // FK ke staff
            $table->foreignId('tenant_id')->constrained('tenant')->onDelete('cascade');;
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
            $table->decimal('total_komisi', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
