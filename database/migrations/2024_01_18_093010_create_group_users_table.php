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
        Schema::create('group_users', function (Blueprint $table) {
            $table->id();

            $table->string('role', 25); // user, admin
            $table->string('status', 25); //approved or pending
            $table->string('token',1024)->nullable(); // for invitation to the group

            $table->timestamp('token_expires_on')->nullable();
            $table->timestamp('token_used_on')->nullable();

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('group_id')->constrained('groups');
            $table->foreignId('created_by')->constrained('users'); // admin adding someone into the group

            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_users');
    }
};
