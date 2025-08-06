<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../backend/meta-include.php'; ?>
    <link rel="stylesheet" href="../css/table.css">
    <title>Tables - Type://Kars</title>
    <style>
        .contents {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .contents div {
            width: calc(20% - 8px); /* 20% for 5 items per row, minus gap space */
            aspect-ratio: 1 / 1;
            margin-bottom: 10px;

            text-decoration: none;
            text-align: center;

            border: 1px solid white; border-radius: 2em;
        }

        .contents div a {
            color: white;
            text-decoration: none;
            font-size: 1.2em;
        }

        /* Make it responsive */
        @media (max-width: 768px) {
            .contents div {
                width: calc(50% - 5px); /* 2 items per row on tablets */
            }
        }

        @media (max-width: 480px) {
            .contents div {
                width: 100%; /* 1 item per row on mobile */
            }
        }
    </style>
</head>
<body>
    <main-element class="welcome">
        <h1 title>Tables</h1>
    </main-element>

    <main-element>
        <h2>Contents</h2>
        <div class="contents">
            <div><a href="#elements">Elements</a></div>
            <div><a href="#items">Items</a></div>
            <div><a href="#codes">Codes</a></div>
            <div><a href="#">BLANK</a></div>
            <div><a href="#">BLANK</a></div>
            <div><a href="#">BLANK</a></div>
            <div><a href="#">BLANK</a></div>
            <div><a href="#">BLANK</a></div>
            <div><a href="#">BLANK</a></div>

        </div>
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