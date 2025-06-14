<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

    Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('plan_type')->nullable();
            $table->text('description')->nullable();
            $table->text('job_types')->nullable();
            $table->text('job_domain')->nullable();
            $table->string('booth_location')->nullable();
            $table->string('photo')->nullable();
            $table->integer('speeddate_duration')->nullable();
            $table->string('company_description')->nullable();
            $table->string('job_requirements')->nullable();
            $table->string('job_description')->nullable();
            $table->timestamps();
        });

 Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('study_direction')->nullable();
            $table->string('graduation_track')->nullable();
            $table->text('interests')->nullable();
            $table->text('job_preferences')->nullable();
            $table->string('cv')->nullable();
            $table->boolean('profile_complete')->default(false);
            $table->timestamps();
        });

        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('actor')->nullable();
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
            $table->string('time_slot');
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
    }
};
