<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Console\Kernel;

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$user = User::where('email', 'admin@akwaaba360.com')->first();
if ($user) {
    $user->password = Hash::make('admin123');
    $user->save();
    echo "Password updated successfully to: " . $user->password . "\n";
} else {
    echo "User not found!\n";
}
