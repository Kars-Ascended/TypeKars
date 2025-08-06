<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../backend/meta-include.php'; ?>
    <title>Tables - Type://Kars</title>
    <style>
        @media only screen and (max-width: 768px) {
            main-element.welcome .left{
                display: none !important;
            }
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #242424ff;
        }
        .table-container {
            margin: 20px;
        }
    </style>
</head>
<body>
    <main-element class="welcome">
        <h1 title>Tables</h1>
    </main-element>

    <main-element>
        <h2>Contents</h2>
        <ul>
            <li><a href="#elements">Elements</a></li>
            <li><a href="#items">Items</a></li>
            <li><a href="#codes">Codes</a></li>
        </ul>
    </main-element>
    <div class="table-container">
        <?php
        // Connect to the database
        $dbFile = __DIR__ . '/../db/typekars.db';
        $db = new PDO('sqlite:' . $dbFile);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Function to display table
        function displayTable($db, $tableName) {
            echo "<h2>" . ucfirst($tableName) . "</h2>";
            $stmt = $db->query("SELECT * FROM " . $tableName);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($rows) > 0) {
                echo "<table>";
                // Header
                echo "<tr>";
                foreach (array_keys($rows[0]) as $header) {
                    echo "<th>" . htmlspecialchars($header) . "</th>";
                }
                echo "</tr>";
                
                // Data
                foreach ($rows as $row) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value ?? '') . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No data in " . $tableName . "</p>";
            }
        }

        // Display all tables
        try {
            displayTable($db, 'elements');
            displayTable($db, 'items');
            displayTable($db, 'codes');
        } catch (PDOException $e) {
            echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>
</body>
</html>