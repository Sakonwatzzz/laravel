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
        Schema::create('notes', function (Blueprint $table) {

            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('email')->nullable(); // เพิ่ม nullable() ถ้าต้องการให้เป็นค่าว่างได้
            $table->string('title');
            $table->string('content');
            $table->string('file')->nullable()->change();
            $table->string('image')->nullable()->change();
            $table->timestamps();
        });


    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
