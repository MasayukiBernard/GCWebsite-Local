<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('personal_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('csa_form_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name', 75);
            $table->char('nim', 10);
            $table->string('picture_path', 100);
            $table->string('gender', 10);
            $table->string('place_birth', 50);
            $table->date('date_birth');
            $table->string('nationality', 20);
            $table->string('email', 50);
            $table->char('mobile', 13);
            $table->char('telp_num', 14);
            $table->string('address', 200);
            $table->string('flazz_card_picture_path', 100);
            $table->string('id_card_picture_path', 100);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_information');
    }
}
