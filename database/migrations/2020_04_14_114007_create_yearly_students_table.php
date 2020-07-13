<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearlyStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yearly_students', function (Blueprint $table) {
            $table->id();
            $table->char('nim', 10);
            $table->integer('academic_year_id');
            $table->boolean('is_nominated');
            $table->timestamp('latest_created_at')->nullable();
            $table->timestamp('latest_updated_at')->nullable();
            $table->softDeletes('latest_deleted_at')->nullable();

            $table->foreign('nim')
                ->references('nim')
                ->on('students')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yearly_students');
    }
}
