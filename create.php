<?php
$name = '';
$address = '';
$message = '';

include 'config.php'; 


if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $name = $_POST["name"];
    $address = $_POST["address"];


    if (!empty($name) && !empty($address)) {
        try {
            
            $sql = "INSERT INTO employees (Name, Address) VALUES (:name, :address)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $message = "Employee added successfully!";
               
                $name = '';
                $address = '';
            } else {
                $message = "Error adding employee.";
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "Both Name and Address are required.";
    }
}

$conn = null; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <style>
        .message {
            margin: 10px 0;
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Employee</h1>
   
        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : ''; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form action="create.php" method="POST">
            <label for="name">Name:</label><br>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"><br><br>

            <label for="address">Address:</label><br>
            <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>"><br><br>

            <input type="submit" value="Add Employee">
        </form>
    </div>
</body>
</html>
