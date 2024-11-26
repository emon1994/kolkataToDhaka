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
      
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('password');
            $table->date('dob')->nullable();
            $table->string('fb_id_link')->nullable();
            $table->string('country')->nullable(); 
            $table->text('address')->nullable();
            $table->string('dress_size')->nullable();
            $table->string('shoe_size')->nullable();
            $table->integer('discount')->default(0);
            $table->string('status')->default('Newbie');
            $table->string('review')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
