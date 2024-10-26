<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->string('name');
            $table->char('document', 11)->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('birthdate');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('set null');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
