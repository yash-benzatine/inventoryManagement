<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code');
            $table->string('product_id');
            $table->string('customer');
            $table->date('date');
            $table->integer('sub_total', 10, 2);
            $table->integer('discount', 10, 2)->nullable();
            $table->integer('vat', 10, 2)->nullable();
            $table->integer('grand_total', 10, 2);
            $table->integer('received_amount', 10, 2);
            $table->integer('due', 10, 2);
            $table->string('payment_type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
