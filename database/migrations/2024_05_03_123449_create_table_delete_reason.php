<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delete_reason', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deleted_user_id');
            $table->string('deleted_user_email');
            $table->string('deleted_user_name');
            $table->foreignId('deleted_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('deleted_by_user_name');
            $table->string('deleted_by_user_email');
            $table->text('reason');
            $table->timestamp('deleted_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delete_reason');
    }
};
