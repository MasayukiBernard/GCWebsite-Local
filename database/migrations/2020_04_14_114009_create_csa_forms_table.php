<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsaFormsTable extends Migration
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
        Schema::create('csa_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yearly_student_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->boolean('is_submitted');
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
        Schema::dropIfExists('csa_forms');
    }
}
