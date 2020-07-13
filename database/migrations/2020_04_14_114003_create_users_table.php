<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_staff');
            $table->string('password', 100);
            $table->string('name', 75);
            $table->char('gender', 1);
            $table->string('email',  50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            // eliminate first zero
            $table->char('mobile', 13);
            $table->char('telp_num', 14);

            $table->rememberToken();
            $table->timestamp('latest_created_at')->nullable();
            $table->timestamp('latest_updated_at')->nullable();
            $table->softDeletes('latest_deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
