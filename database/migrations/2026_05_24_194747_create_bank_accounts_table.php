<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_user_id')->constrained('bank_users')->onDelete('cascade');
            $table->string('account_number', 20)->unique();
            $table->string('agency', 10)->default('0001');
            $table->decimal('balance', 12, 2)->default(0.00);
            $table->enum('type', ['corrente', 'poupanca'])->default('corrente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_accounts');
    }
};
