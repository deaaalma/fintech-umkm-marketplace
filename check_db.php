<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

var_dump(Illuminate\Support\Facades\Schema::hasTable('order_additional_fees'));
$tables = Illuminate\Support\Facades\DB::select('SHOW TABLES');
foreach($tables as $table) {
    var_dump(array_values((array)$table)[0]);
}
