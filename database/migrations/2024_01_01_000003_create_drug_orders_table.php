<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_orders', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('ordered_by_id')->constrained('users')->onDelete('cascade');
            $table->json('items');
            $table->integer('total_quantity');
            $table->decimal('total_amount', 8, 2);
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
        Schema::dropIfExists('drug_orders');
    }
}
