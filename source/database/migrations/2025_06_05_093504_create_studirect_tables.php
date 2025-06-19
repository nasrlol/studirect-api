<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_photo')->nullable();
            $table->string('role')->default('admin');
            $table->timestamps();
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('plan_type')->nullable();
            $table->text('job_types')->nullable();
            $table->text('job_domain')->nullable();
            $table->string('booth_location')->nullable();
            $table->string('photo')->nullable();
            $table->integer('speeddate_duration')->nullable();
            $table->string('company_description')->nullable();
            $table->string('job_title')->nullable();
            $table->string('job_requirements')->nullable();
            $table->string('job_description')->nullable();
            $table->string('company_location')->nullable();
            $table->string('role')->default('company');
            $table->timestamps();
        });

        Schema::create('diplomas', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('study_direction')->nullable();
            $table->foreignId('graduation_track')->nullable()->constrained('diplomas')->onDelete('cascade');
            $table->text('interests')->nullable();
            $table->text('job_preferences')->nullable();
            $table->string('cv')->nullable();
            $table->boolean('profile_complete')->default(false);
            $table->string('profile_photo')->nullable();
            $table->string('role')->default('student');
            $table->timestamps();
        });

        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('actor')->nullable();
            $table->unsignedBigInteger("actor_id");
            $table->text('action');
            $table->string('target_type')->nullable();
            $table->timestamp('timestamp')->useCurrent();
            $table->string('severity')->nullable();
            $table->timestamps();
        });

        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->boolean('status')->default(false);
            $table->float('skill_match_percentage')->default(0);
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->string('sender_type'); // 'student' of 'company'
            $table->string('receiver_type'); // 'student' of 'company'
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->time('time_start');
            $table->time('time_end');
            $table->timestamps();
        });

        // Create the main skills table
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        //  pivot tabel voor de student skills
        Schema::create('skill_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // pivot tabel voor company skills
        Schema::create('company_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('connections');
        Schema::dropIfExists('logs');
        Schema::dropIfExists('students');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('company_skill');
        Schema::dropIfExists('skill_student');
        Schema::dropIfExists('skills');
    }
};
