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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('source')->nullable();
            $table->string('external_id')->nullable();
            $table->string('keyword')->nullable();
            $table->string('location')->nullable();
            $table->string('title')->nullable();
            $table->string('company')->nullable();
            $table->string('location_text')->nullable();
            $table->string('company_url')->nullable();
            $table->string('url')->nullable();
            $table->text('description')->nullable();
            $table->string('date_posted')->nullable();
            $table->boolean('is_remote')->default(false);
            $table->longText('payload')->nullable();
            $table->timestamps();

            $table->unique(['source', 'external_id'], 'job_listings_source_external');
            $table->unique(['source', 'url'], 'job_listings_source_url');
            $table->index(['keyword', 'location']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
