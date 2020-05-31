<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Enabling foreign key constraints
        Schema::enableForeignKeyConstraints();
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name', 50);
            $table->string('location', 30);
            $table->string('short_detail', 100);
            $table->decimal('min_gpa', 3, 2, true);
            $table->string('eng_requirement', 30);
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
        Schema::dropIfExists('partners');
    }
}
