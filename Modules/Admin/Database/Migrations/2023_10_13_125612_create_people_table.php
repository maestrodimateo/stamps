<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Admin\Models\Person;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 200);
            $table->string('firstname')->nullable();
            $table->string('maiden_name')->nullable();
            $table->date('birthdate');
            $table->enum('gender', array_values(Person::GENDERS))->default(Person::GENDERS['male']);
            $table->string('phone')->nullable();
            $table->foreignUuid('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        addFullTextSearchIndex('people', ['name', 'firstname', 'maiden_name']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
