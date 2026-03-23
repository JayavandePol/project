<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    \App\Models\Klant::create([
        'name' => 'Jan Janssen',
        'email' => 'jan@example.com',
        'phone' => '0612345678',
        'address' => 'Hoofdstraat 1, Amsterdam'
    ]);
    echo "Klant created successfully\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
