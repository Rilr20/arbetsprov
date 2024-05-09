<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // products tabell med kolumner för id, name, price.
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->float('price');
            $table->timestamps();
        });
        DB::table('products')->insert([
            ['product_name' => 'Kniv', 'price' => 45.00],
            ['product_name' => 'Gaffel', 'price' => 20.00],
            ['product_name' => 'Sked', 'price' => 5.50],
        ]);
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
