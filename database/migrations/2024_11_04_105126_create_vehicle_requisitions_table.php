<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_requisitions', function (Blueprint $table) {
            $table->id();
            $table->enum('applicant_type', ['government', 'private']);
            $table->date('usage_date'); // Date of requisition
            $table->date('requisition_date'); // Date of requisition
            $table->time('from_time')->nullable(); // Time of requisition
            $table->time('to_time')->nullable(); // Time of requisition
            $table->bigInteger('employee_id');
            $table->bigInteger('district_id');
            $table->string('from_location');
            $table->string('to_location');
            $table->string('total_miles')->nullable();
            $table->string('expense_type')->nullable();
            $table->string('name_of_project')->nullable();
            $table->bigInteger('type_id');
            $table->string('number_of_passenger')->nullable();
            $table->text('purpose')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('forward_status')->default(1);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('vehicle_requisitions');
    }
}
