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
            $table->foreignId('hotel_type_id')->constrained('hotel_types','id')->cascadeOnDelete();
            $table->string('phone');
            $table->string('alternate_phone')->nullable();
            $table->text('address');
            $table->text('alternate_address')->nullable();
            $table->string('country');
            $table->string('city');
            $table->string('zip');
            $table->boolean('is_active');
            $table->foreignId('user_id')->constrained('users','id')->cascadeOnDelete();
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
