<?php
$db = new mysqli('localhost', 'root', '', 'himaprosif');
if ($db->connect_error) { echo 'ERROR: ' . $db->connect_error; exit(1); }

$db->query("CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','user') DEFAULT 'user',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$adminPass = password_hash('admin123', PASSWORD_BCRYPT);
$userPass  = password_hash('user123',  PASSWORD_BCRYPT);

$stmt = $db->prepare("INSERT IGNORE INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->bind_param('sss', $u, $p, $r);

$u = 'admin'; $p = $adminPass; $r = 'admin'; $stmt->execute();
$u = 'user';  $p = $userPass;  $r = 'user';  $stmt->execute();

echo "Done. Users table ready. Accounts seeded.\n";
$db->close();
