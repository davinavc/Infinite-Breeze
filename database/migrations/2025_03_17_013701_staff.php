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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Hubungkan ke users
            $table->foreignId('dpt_id')->constrained('department')->onDelete('cascade');
            $table->string('nm_depan', 25);
            $table->string('nm_blkg', 50)->nullable();
            $table->date('birth_date');
            $table->string('no_telp', 14);
            $table->string('alamat', 100);
            $table->string('referral_code', 30)->unique();
            $table->enum('status', ['Volunteer', 'Staff', 'Manager', 'Resign']);
            $table->date('tgl_exit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
