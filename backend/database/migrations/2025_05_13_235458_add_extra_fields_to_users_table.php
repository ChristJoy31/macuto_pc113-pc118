<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('address')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->date('birthdate')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('religion')->nullable();
            $table->string('position')->nullable(); // For admin/secretary
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'middle_name',
                'suffix',
                'contact_number',
                'address',
                'gender',
                'birthdate',
                'civil_status',
                'citizenship',
                'religion',
                'position',
            ]);
        });
    }
    
};
