<?php
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::first();
if (! $user) {
    echo "No users found.\n";
    exit(1);
}

$password = 'Password123!';
$user->password = password_hash($password, PASSWORD_BCRYPT);
$user->email_verified_at = date('Y-m-d H:i:s');
$user->save();

echo "Updated user id={$user->id} email={$user->email}\n";
echo "New password: {$password}\n";
echo "Email marked verified.\n";
