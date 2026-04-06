<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("IF OBJECT_ID('personnel_profiles', 'U') IS NOT NULL DROP TABLE personnel_profiles");

        DB::statement("CREATE TABLE [personnel_profiles] (
            [id] bigint identity not null,
            [user_id] bigint not null,
            [first_name] nvarchar(255) not null,
            [surname] nvarchar(255) not null,
            [gender] nvarchar(255) not null,
            [residence] nvarchar(1000) not null,
            [university] nvarchar(255) not null,
            [program] nvarchar(255) not null,
            [region] nvarchar(255) not null,
            [academic_year] nvarchar(255) not null,
            [posting_letter_path] nvarchar(255) not null,
            [confirmed_at] datetime not null,
            [created_at] datetime,
            [updated_at] datetime,
            primary key ([id]),
            constraint [personnel_profiles_user_id_unique] unique ([user_id])
        )");

        // Add foreign key via separate statement
        DB::statement("ALTER TABLE [personnel_profiles] ADD CONSTRAINT [personnel_profiles_user_id_foreign] FOREIGN KEY ([user_id]) REFERENCES [users] ([id]) ON DELETE CASCADE");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnel_profiles');
    }
};
