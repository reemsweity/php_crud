<?php
include 'config.php'; // Include the database connection file

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Prepare the SQL statement to fetch the employee based on the ID
        $sql = "SELECT id, Name, Address, Salary FROM employees WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if an employee with the given ID exists
        if ($stmt->rowCount() > 0) {
            $employee = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "<p>Employee not found.</p>";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "<p>Invalid ID.</p>";
    exit;
}

$conn = null; // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #c85a2e;
            text-align: left;
            border-bottom: 2px solid #f2f2f2;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .back-btn {
            background-color: #c85a2e;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Employee Details</h1>
        <table>
            <tr>
                <td><strong>ID:</strong></td>
                <td><?php echo $employee['id']; ?></td>
            </tr>
            <tr>
                <td><strong>Name:</strong></td>
                <td><?php echo $employee['Name']; ?></td>
            </tr>
            <tr>
                <td><strong>Address:</strong></td>
                <td><?php echo $employee['Address']; ?></td>
            </tr>
            <tr>
                <td><strong>Salary:</strong></td>
                <td><?php echo $employee['Salary']; ?></td>
            </tr>
        </table>

        <a href="index.php" class="back-btn">← Back to Employee List</a>
    </div>
</body>
</html>
