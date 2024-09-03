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
        Schema::table('notes', function (Blueprint $table) {
            // ตัวอย่างการเปลี่ยน data type หรือเพิ่ม index
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            // ถ้าคุณเปลี่ยน data type ในฟังก์ชัน up() คุณควรเปลี่ยนกลับในที่นี่

            // จากนั้นจึงลบ index และคอลัมน์
            $table->dropIndex('notes_user_id_index');
            $table->dropColumn('user_id');
        });
    }
};
