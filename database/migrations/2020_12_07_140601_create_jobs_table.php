<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 150);
            $table->text('description');
            $table->foreignId('employee_id');
            $table->foreignId('city_id');
            $table->foreignId('county_id');
            $table->text('address');
            $table->date('date');
            $table->time('started_at');
            $table->time('finished_at');
            $table->enum('status', ['İş Oluşturuldu', "İş'e Gidiliyor", 'İşlemde', 'İş Tamamlandı']);
            $table->integer('priority')->default(0);
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('county_id')->references('id')->on('counties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('works');
    }
}
