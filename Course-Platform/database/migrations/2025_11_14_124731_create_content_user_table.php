<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_xx_xx_xxxxxx_create_content_user_table.php
public function up(): void
{
    Schema::create('content_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('content_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->boolean('is_done')->default(false);
        $table->timestamp('completed_at')->nullable();
        $table->timestamps();

        $table->unique(['content_id','user_id']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_user');
    }
};
