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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->string('product_name');
            $table->date('invoice_date');
            $table->integer('invoice_quantity');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('vat_rate', 5, 2);
            $table->string('place');
            $table->timestamps();
            $table->unique(['invoice_number', 'product_name']);
        });

        //Schema::table('invoices', );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
