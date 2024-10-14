<?php
include 'config.php';
try{
    // Fetch employees from the database
    $sql = "SELECT id, Name, Address, Salary FROM employees";
    $result = $conn->query($sql);

    // Display the employees' data if available
    if ($result->rowCount() > 0) {
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Employees Details</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f7f7f7;
                }
                h1 {
                    color: #c85a2e;
                    text-align: left;
                }
                .container {
                    width: 80%;
                    margin: 0 auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                table th, table td {
                    border: 1px solid #ddd;
                    padding: 12px;
                    text-align: left;
                }
                table th {
                    background-color: #f2f2f2;
                    color: #c85a2e;
                }
                table tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                table tr:hover {
                    background-color: #f1f1f1;
                }
                .action-btn {
                    text-decoration: none;
                    padding: 6px 12px;
                    border-radius: 4px;
                    margin-right: 5px;
                }
                .edit-btn {
                    background-color: #c85a2e;
                    color: white;
                }
                .delete-btn {
                    background-color: #c85a2e;
                    color: white;
                }
                .view-btn {
                    background-color: #c85a2e;
                    color: white;
                }
                .add-employee {
                    background-color: #c85a2e;
                    color: white;
                    padding: 10px 20px;
                    text-decoration: none;
                    border-radius: 4px;
                    float: right;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Employees Details</h1>
                <a href="create.php" class="add-employee">+ Add New Employee</a>
                <table>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Salary</th>
                        <th>Action</th>
                    </tr>';

        // Iterate through the employee rows and display them
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $row['Address'] . "</td>";
            echo "<td>" . $row['Salary'] . "</td>";
            echo "<td>";
            echo "<a href='view.php?id=" . $row['id'] . "' class='action-btn view-btn'>👁️</a>";
            echo "<a href='edit.php?id=" . $row['id'] . "' class='action-btn edit-btn'>✏️</a>";
            echo "<a href='delete.php?id=" . $row['id'] . "' class='action-btn delete-btn'>🗑️</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo '</table>
            </div>
        </body>
        </html>';
    } else {
        echo "No results found.";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
