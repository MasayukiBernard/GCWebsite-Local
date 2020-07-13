<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearlyPartnersTable extends Migration
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
        Schema::create('yearly_partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');;
            $table->foreignId('partner_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');;
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
        Schema::dropIfExists('yearly_partners');
    }
}
