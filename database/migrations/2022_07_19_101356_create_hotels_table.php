<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('contact_name');
            $table->foreignId('property_type_id')->constrained('property_types','id');
            $table->string('hotel_type_id');
            $table->string('amenity_id');
            $table->string('star_rating');
            $table->string('phone');
            $table->string('alternate_phone')->nullable();
            $table->text('address');
            $table->text('alternate_address')->nullable();
            $table->string('country');
            $table->string('city');
            $table->string('zip');
            $table->boolean('is_active')->default(true);
            $table->morphs('creatable');
            $table->softDeletes();
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
        Schema::dropIfExists('hotels');
    }
};
