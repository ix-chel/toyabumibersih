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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('supervisor_name');
            $table->string('supervisor_phone');
            $table->string('company_phone');
            $table->string('company_email');
            $table->string('supervisor_email');
            $table->text('address');
            $table->integer('total_store')->default(0);
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
        Schema::dropIfExists('companies');
    }
}; 