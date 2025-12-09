<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('glasses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');     // opticien propriétaire
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            $table->string('reference');           // ex: RB4640, Wayfarer, VO4105...
            $table->string('slug')->unique();
            $table->string('color');
            
            $table->decimal('price', 10, 2);                   // prix de vente TTC
            $table->decimal('purchase_price', 10, 2)->nullable(); // prix d'achat HT
            
            // Images
            // Images classiques
            $table->string('image_front')->nullable();     // photo de face (obligatoire pour try-on)
            $table->string('image_side')->nullable();
            $table->string('image_worn')->nullable();
            
            // Mesures physiques en mm → indispensables pour l’essayage virtuel live
            $table->unsignedInteger('total_width');     // largeur totale monture
            $table->unsignedInteger('lens_width');      // largeur verre
            $table->unsignedInteger('bridge_width');    // largeur pont
            $table->unsignedInteger('temple_length');   // longueur des branches

            // Modèle 3D pour le try-on live (GLTF généré automatiquement plus tard)
            $table->string('gltf_model')->nullable();

            $table->integer('stock')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('glasses');
    }
};