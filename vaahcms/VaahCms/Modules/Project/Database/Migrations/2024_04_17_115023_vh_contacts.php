<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VhContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('vh_contacts')) {
            Schema::create('vh_contacts', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->uuid('uuid')->nullable()->index();
                $table->unsignedBigInteger('vh_company_id')->nullable()->index();
                $table->unsignedBigInteger('added_by')->nullable()->index();
                $table->string('first_name',150)->nullable()->index();
                $table->string('middle_name')->nullable()->index();
                $table->string('last_name',150)->nullable()->index();
                $table->string('email',150)->nullable()->index();
                $table->bigInteger('phone')->nullable()->index();
                $table->bigInteger('fax_number')->nullable()->index();
                $table->string('zip_code')->nullable()->index();
                $table->string('city')->nullable();
                $table->string('street')->nullable();
                $table->string('country')->nullable();
                $table->string('state')->nullable();
                $table->string('suit')->nullable();
                $table->bigInteger('credit_limit')->nullable()->index();
                $table->bigInteger('credit_card_number')->nullable()->index();
                $table->text('cvv')->nullable()->index();
                $table->bigInteger('tax_id')->nullable()->index();
                $table->decimal('tax_rate', 8, 2)->nullable()->index();
                $table->decimal('discount_percentage', 8, 2)->nullable();
                $table->decimal('max_discount_amount', 10, 2)->nullable();
                $table->decimal('total_amount', 12, 2)->nullable();
                $table->date('validation_date')->nullable();
                $table->bigInteger('expires_month')->nullable();
                $table->bigInteger('expires_year')->nullable();
                $table->string('payment_terms')->nullable();
                $table->string('comments')->nullable();
                $table->boolean('is_tax_payer')->nullable()->index();
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
        Schema::dropIfExists('vh_contacts');
    }
}
