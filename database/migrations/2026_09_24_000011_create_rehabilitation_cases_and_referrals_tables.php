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
        Schema::create('rehabilitation_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->unique();
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('service_request_id')->nullable()->constrained('service_requests')->nullOnDelete();
            $table->foreignId('complaint_id')->nullable()->constrained('complaints')->nullOnDelete();
            $table->foreignId('officer_id')->constrained('users');
            $table->string('handling_type')->default('direct'); // direct|referral|both
            $table->string('status')->index();
            $table->text('handling_result')->nullable();
            $table->timestampTz('received_at');
            $table->timestampTz('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rehabilitation_case_id')->constrained('rehabilitation_cases')->cascadeOnDelete();
            $table->foreignId('officer_id')->constrained('users');
            $table->date('assessment_date');
            $table->text('result');
            $table->text('service_needs');
            $table->text('recommendation');
            $table->boolean('needs_referral')->default(false);
            $table->timestamps();
        });

        Schema::create('referral_institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // panti, balai, RS, LKS
            $table->text('address')->nullable();
            $table->string('contact')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->string('referral_number')->unique();
            $table->foreignId('rehabilitation_case_id')->constrained('rehabilitation_cases')->cascadeOnDelete();
            $table->foreignId('assessment_id')->constrained('assessments');
            $table->foreignId('referral_institution_id')->constrained('referral_institutions');
            $table->foreignId('officer_id')->constrained('users');
            $table->date('referral_date');
            $table->string('status')->index();
            $table->text('service_result')->nullable();
            $table->timestampTz('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('monitoring_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rehabilitation_case_id')->constrained('rehabilitation_cases')->cascadeOnDelete();
            $table->foreignId('referral_id')->nullable()->constrained('referrals')->nullOnDelete();
            $table->foreignId('officer_id')->constrained('users');
            $table->date('monitoring_date');
            $table->text('progress');
            $table->text('result_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_records');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('referral_institutions');
        Schema::dropIfExists('assessments');
        Schema::dropIfExists('rehabilitation_cases');
    }
};
