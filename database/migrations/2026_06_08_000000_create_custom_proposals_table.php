<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('custom_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->string('craft_type');
            $table->string('material');
            $table->decimal('budget', 15, 2);
            $table->integer('deadline_days');
            $table->text('description');
            $table->string('difficulty');
            $table->integer('estimated_days');
            $table->decimal('material_cost', 15, 2);
            $table->decimal('labor_cost', 15, 2);
            $table->string('shop_recommendation');
            $table->text('agent_reasoning')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'ordered'])->default('pending');
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('custom_proposals');
    }
};
