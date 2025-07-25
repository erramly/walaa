<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// قاعدة بيانات متصلة؟
$dbName = DB::getDatabaseName();
$tables = DB::select("SHOW TABLES");
$key = 'Tables_in_' . $dbName;

foreach ($tables as $table) {
    $tableName = $table->$key;

    // تجاهل بعض الجداول
    if (in_array($tableName, ['migrations', 'restaurant_customer', 'password_resets', 'failed_jobs', 'personal_access_tokens', 'password_reset_tokens'])) {
        continue;
    }

    // اسم الموديل
    $modelName = Str::studly(Str::singular($tableName));
    $controllerName = $modelName . 'Controller';

    echo "📦 Generating Model: $modelName for table: $tableName\n";

    // توليد الموديل باستخدام krlove
    Artisan::call('krlove:generate:model', [
        'class-name' => $modelName,
        '--output-path' => 'app',
        '--namespace' => 'App\Models',
    ]);

    echo "🛠️ Generating Controller: $controllerName for model: $modelName\n";

    // توليد الكنترولر مرتبط بالموديل
    Artisan::call('make:controller', [
        'name' => $controllerName,
        '--resource' => true,
        '--model' => "App\\Models\\$modelName",
    ]);
}

echo "✅ تم توليد جميع الموديلات والمتحكمات بنجاح!\n";
