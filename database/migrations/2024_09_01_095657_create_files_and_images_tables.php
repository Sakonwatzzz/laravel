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
        Schema::create('files',function(Blueprint $table) {
            $table->id();
            $table->foreignId('note_id')->constrained()->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');
            $table->timestamps();
        });
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('note_id')->constrained()->onDelete('cascade');  // เชื่อมโยงกับตาราง notes
            $table->string('image_name');  // ชื่อรูปภาพ
            $table->string('image_path');  // ที่เก็บรูปภาพในเซิร์ฟเวอร์
            $table->string('alt_text')->nullable(); // ข้อความอธิบายรูปภาพ (optional)
            $table->string('mime_type'); // ชนิดของรูปภาพ
            $table->unsignedBigInteger('image_size'); // ขนาดของรูปภาพ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
        Schema::dropIfExists('images');
    }
};
