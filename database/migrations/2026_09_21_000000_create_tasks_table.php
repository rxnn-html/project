<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Creates the tasks table with the fields required by the project spec
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // auto-incrementing task ID
            $table->string('title');            // name of the task
            $table->text('description')->nullable(); // task details
            $table->string('priority')->default('Reminder'); // priority level
            $table->string('status')->default('pending'); // task status
            $table->date('due_date')->nullable();    // task deadline
            $table->timestamps(); // created_at / updated_at
        });
    }

    // Drops the tasks table when rolling back
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};