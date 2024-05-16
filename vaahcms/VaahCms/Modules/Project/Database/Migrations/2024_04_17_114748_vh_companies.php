<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VhCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('vh_companies')) {
            Schema::create('vh_companies', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->uuid('uuid')->nullable()->index();

                $table->string('name')->nullable()->index();
                $table->string('slug')->nullable()->index();
                $table->string('email',150)->nullable()->index();
                $table->bigInteger('phone')->nullable()->index();
                $table->bigInteger('fax_number')->nullable()->index();
                $table->string('zip_code')->nullable()->index();
                $table->string('city')->nullable();
                $table->string('street')->nullable();
                $table->string('country')->nullable();
                $table->string('suit')->nullable();
                $table->boolean('is_active')->nullable()->index();


                //----common fields
                $table->text('meta')->nullable();
                $table->bigInteger('created_by')->nullable()->index();
                $table->bigInteger('updated_by')->nullable()->index();
                $table->bigInteger('deleted_by')->nullable()->index();
                $table->timestamps();
                $table->softDeletes();
                $table->index(['created_at', 'updated_at', 'deleted_at']);
                //----/common fields

            });
        }

    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('vh_companies');
    }
}