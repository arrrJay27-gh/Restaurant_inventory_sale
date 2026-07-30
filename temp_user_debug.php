<?php
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$u = User::first();
if (! $u) {
    echo "no users\n";
    exit(0);
}
echo "id={$u->id}\n";
echo "email={$u->email}\n";
echo "verified=" . ($u->email_verified_at ? 'yes' : 'no') . "\n";
echo "password={$u->password}\n";
