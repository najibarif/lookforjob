<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('scraped_jobs', function (Blueprint $table) {
            $table->text('description')->nullable()->after('location');
            $table->text('requirements')->nullable()->after('description');
            $table->string('employment_type')->default('Full-time')->after('requirements');
            $table->string('experience_level')->default('Mid Level')->after('employment_type');
            $table->string('category')->default('General')->after('keyword');
            $table->boolean('is_remote')->default(false)->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scraped_jobs', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'requirements',
                'employment_type',
                'experience_level',
                'category',
                'is_remote',
            ]);
        });
    }
};
