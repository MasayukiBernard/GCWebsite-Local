<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConditionsTable extends Migration
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
        Schema::create('conditions', function (Blueprint $table) {
            // Foreign Key Constraint on Database level for AUTO_INC id shorthand
            $table->foreignId('csa_form_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->primary();
            $table->boolean('med_condition');
            $table->boolean('allergy');
            $table->boolean('special_diet');
            $table->boolean('convicted_crime');
            $table->boolean('future_diffs');
            $table->text('reasons');
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
        Schema::dropIfExists('conditions');
    }
}
