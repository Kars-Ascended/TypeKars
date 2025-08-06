<?php
// Database file path
$dbFile = __DIR__ . '/typekars.db';

// Create (or open) the SQLite database
$db = new PDO('sqlite:' . $dbFile);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create tables with correct columns
$db->exec("
    CREATE TABLE IF NOT EXISTS elements (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        shinigami TEXT,
        hollow TEXT,
        quincy TEXT,
        fullbringer TEXT
    );
    CREATE TABLE IF NOT EXISTS items (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        item TEXT,
        description TEXT,
        usage TEXT
    );
    CREATE TABLE IF NOT EXISTS codes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        code TEXT,
        status TEXT,
        rewards TEXT
    );
");

// Helper function to import CSV
function importCsv($db, $csvFile, $table, $columns) {
    if (!file_exists($csvFile)) {
        echo "File not found: $csvFile\n";
        return;
    }
    $handle = fopen($csvFile, 'r');
    if (!$handle) {
        echo "Could not open $csvFile\n";
        return;
    }
    // Skip header
    fgetcsv($handle);
    $placeholders = implode(',', array_fill(0, count($columns), '?'));
    $stmt = $db->prepare("INSERT INTO $table (" . implode(',', $columns) . ") VALUES ($placeholders)");
    while (($data = fgetcsv($handle)) !== false) {
        // Only use as many columns as expected
        $data = array_slice($data, 0, count($columns));
        // Pad data if row is short
        $data = array_pad($data, count($columns), null);
        $stmt->execute($data);
    }
    fclose($handle);
    echo "Imported $csvFile into $table\n";
}

// Import each CSV with correct columns
importCsv(
    $db,
    __DIR__ . '/../data/elements.csv',
    'elements',
    ['shinigami', 'hollow', 'quincy', 'fullbringer']
);
importCsv(
    $db,
    __DIR__ . '/../data/items.csv',
    'items',
    ['item', 'description', 'usage']
);
importCsv(
    $db,
    __DIR__ . '/../data/codes.csv',
    'codes',
    ['code', 'status', 'rewards']
);

echo "Import complete.\n";
?>