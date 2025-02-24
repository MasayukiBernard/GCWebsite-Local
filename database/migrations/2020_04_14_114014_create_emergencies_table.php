<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergenciesTable extends Migration
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
        Schema::create('emergencies', function (Blueprint $table) {
            $table->foreignId('csa_form_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->char('gender', 1);
            $table->string('name', 75);
            $table->string('relationship', 20);
            $table->string('address', 200);
            $table->char('mobile', 13);
            $table->char('telp_num', 14);
            $table->string('email', 50);
            $table->timestamp('latest_created_at')->nullable();
            $table->timestamp('latest_updated_at')->nullable();
            $table->softDeletes('latest_deleted_at')->nullable();

            $table->primary('csa_form_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emergencies');
    }
}
