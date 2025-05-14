<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('photo')->nullable();  
            $table->enum('role', ['admin', 'secretary', 'resident']); 
    
            // Optional fields for secretaries and admins
            $table->string('contact_number')->nullable();  
            $table->string('address')->nullable(); 
            $table->string('position')->nullable(); 
            
            // Personal info fields (optional for all roles)
            $table->enum('gender', ['Male', 'Female'])->nullable();  
            $table->date('birthdate')->nullable();  
            $table->string('civil_status')->nullable();  
            $table->string('citizenship')->nullable(); 
            $table->string('religion')->nullable();  
            
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}