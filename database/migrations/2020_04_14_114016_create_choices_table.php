<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChoicesTable extends Migration
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
        Schema::create('choices', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('csa_form_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('yearly_partner_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade'); 
            $table->text('motivation');
            $table->boolean('nominated_to_this');
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
        Schema::dropIfExists('choices');
    }
}
