<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPropertiesTable extends Migration
{
    public function up()
    {
        Schema::create('item_properties', function (Blueprint $table) {
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('value');
            $table->primary(['item_id', 'property_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_properties');
    }
}

