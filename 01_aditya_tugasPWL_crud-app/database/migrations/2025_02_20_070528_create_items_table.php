<?php

// Import Migration untuk membuat perubahan pada struktur tabel di database
use Illuminate\Database\Migrations\Migration;
// Import Blueprint untuk mendefinisikan kolom pada tabel
use Illuminate\Database\Schema\Blueprint;
// Import Schema untuk menjalankan perintah pembuatan dan penghapusan tabel
use Illuminate\Support\Facades\Schema;

// Membuat class anonymous untuk migration
return new class extends Migration
{
    /**
     * Function up untuk membuat tabel 'items'
     * Function ini akan dijalankan saat melakukan migrasi (php artisan migrate)
     */
    public function up(): void
    {
        // Membuat tabel 'items'
        Schema::create('items', function (Blueprint $table) {
            $table->id();                           // Membuat kolom id sebagai primary key dan auto increment
            $table->string('name');         // Membuat kolom name dengan tipe string
            $table->text('description');    // Membuat kolom description dengan tipe text
            $table->timestamps();                   // Membuat kolom created_at dan updated_at otomatis
        });
    }

    /**
     * Function down untuk menghapus tabel 'items'
     * Function ini dijalankan saat rollback migration (php artisan migrate:rollback)
     */
    public function down(): void
    {
        Schema::dropIfExists('items'); // Menghapus tabel 'items' jika ada
    }
};
