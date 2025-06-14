<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id('gambar_produk_id'); // PK
            $table->string('gambar');
            $table->timestamp('waktu_upload')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
