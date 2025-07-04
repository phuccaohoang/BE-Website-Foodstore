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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 200)->unique();
            $table->foreignId('category_id')->constrained('categories');
            $table->string('description', 300)->nullable();
            $table->decimal('price', 10, 2)->unsigned();
            $table->unsignedInteger('sold')->default(0);
            $table->unsignedTinyInteger('discount')->default(0);
            $table->double('rating', 8, 2)->unsigned()->nullable();
            $table->boolean('status')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
