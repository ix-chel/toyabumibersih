<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackComplaintsTable extends Migration
{
    public function up()
    {
        Schema::create('feedback_complaints', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama pengirim feedback
            $table->string('email'); // Email pengirim
            $table->enum('type', ['Feedback', 'Complaint']);
            $table->text('description');
            $table->enum('status', ['Open', 'In Progress', 'Resolved', 'Closed'])->default('Open');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback_complaints');
    }
}
