<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassportsTable extends Migration
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
        Schema::create('passports', function (Blueprint $table) {
            $table->foreignId('csa_form_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->primary();
            $table->char('pass_num', 9);
            $table->date('pass_expiry');
            $table->string('pass_proof_path', 100);
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
        Schema::dropIfExists('passports');
    }
}
