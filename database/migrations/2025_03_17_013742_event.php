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
        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->string('event_name', 100);
            $table->string('place', 100);
            $table->string('theme', 100);
            $table->date('start_date');
            $table->date('finish_date');
            $table->string('poster')->nullable();
            $table->date('tm')->nullable();
            $table->string('tm_link')->nullable();
            $table->integer('tenant_quota');
            $table->integer('supported_electricity');
            $table->decimal('price_per_watt', 15, 2)->nullable();
            $table->decimal('harga', 15, 2)->nullable();
            $table->decimal('capital', 15, 2);
            $table->decimal('revenue', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};
