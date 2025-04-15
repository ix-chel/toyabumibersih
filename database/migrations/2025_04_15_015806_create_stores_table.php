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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('store_code')->unique();
            $table->text('address');
            $table->string('city');
            $table->string('province');
            $table->string('phone');
            $table->string('supervisor_name');
            $table->string('supervisor_email');
            $table->string('supervisor_phone');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->date('joined_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
}; 
