<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_part_useds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('maintenance_reports')->onDelete('cascade');
            $table->string('part_name');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_part_useds');
    }
};
