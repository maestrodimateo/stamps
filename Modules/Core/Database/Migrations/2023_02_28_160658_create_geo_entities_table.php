<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Core\Models\GeoEntity;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_entities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("code")->nullable()->unique();
            $table->string("name")->unique();
            $table->enum("type", GeoEntity::TYPES)->default('COUNTRY');
            $table->foreignUuid("parent_id")->nullable();
            $table->timestamps();
        });

        addFullTextSearchIndex('geo_entities', ['name']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geo_entities');
    }
};
