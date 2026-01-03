<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Committee system ke liye extra fields
            $table->string('phone')->unique()->nullable()->after('email');
            $table->string('cnic')->unique()->nullable()->after('phone');
            $table->text('address')->nullable()->after('cnic');
            $table->string('avatar')->nullable()->after('address');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->string('bank_account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('easypaisa_number')->nullable();
            $table->string('jazzcash_number')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'cnic', 'address', 'avatar', 'status',
                'bank_account_number', 'bank_name', 
                'easypaisa_number', 'jazzcash_number'
            ]);
        });
    }
};