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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // تعيين UUID كمفتاح رئيسي
            $table->morphs('notifiable'); // إنشاء notifiable_id و notifiable_type
            $table->string('type'); // تخزين نوع الإشعار
            $table->text('data'); // تخزين البيانات المتعلقة بالإشعار
            $table->timestamp('read_at')->nullable(); // تخزين وقت قراءة الإشعار
            $table->timestamps(); // إنشاء created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
