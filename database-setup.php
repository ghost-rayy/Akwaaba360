<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Starting database setup...\n";

    // 1. Clean up existing table if it exists
    DB::statement("IF OBJECT_ID('personnel_profiles', 'U') IS NOT NULL DROP TABLE personnel_profiles");
    echo "Cleared old table.\n";

    // 2. Create the table with SQL Server specific naming and types
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
    echo "Created [personnel_profiles] table.\n";

    // 3. Add Foreign Key (Manual cleanup handled by User model to avoid MSSQL Cascade Cycles)
    DB::statement("ALTER TABLE [personnel_profiles] ADD CONSTRAINT [personnel_profiles_user_id_foreign] FOREIGN KEY ([user_id]) REFERENCES [users] ([id])");
    echo "Added Foreign Key constraint.\n";

    // 4. Mark migration as finished
    DB::table('migrations')->updateOrInsert(
        ['migration' => '2026_04_05_211413_create_personnel_profiles_table'],
        ['batch' => 1]
    );
    echo "Updated migration history.\n";

    echo "DATABASE SETUP COMPLETE!\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
