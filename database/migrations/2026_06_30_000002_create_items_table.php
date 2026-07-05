<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('serial_number')->nullable();
            $table->string('nsn')->nullable();
            $table->date('date_acquired')->nullable();
            $table->string('warranty_status')->nullable();
            $table->enum('status', ['Deployed', 'In-Warehouse', 'Under Repair', 'Decommissioned'])->default('In-Warehouse');
            $table->string('location_battalion')->nullable();
            $table->string('location_storage')->nullable();
            $table->string('assigned_personnel')->nullable();
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
