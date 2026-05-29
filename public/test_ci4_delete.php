<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
chdir(__DIR__);
require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

$prokerModel = new \App\Models\ProkerModel();
$partisipanModel = new \App\Models\PartisipanModel();

try {
    $partisipanModel->where('ID_PROKER', 'XX999')->delete();
    echo "SUCCESS\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
