<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Role (admin / member)
            $table->string('role')->default('member')->after('email');

            // Permissions
            $table->boolean('can_edit')->default(false)->after('role');
            $table->boolean('can_delete')->default(false)->after('can_edit');
            $table->boolean('can_add')->default(false)->after('can_delete');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn(['role', 'can_edit', 'can_delete', 'can_add']);
        });
    }
};