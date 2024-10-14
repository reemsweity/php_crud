<?php
include 'config.php';

$id = "";
$name = "";
$address = "";
$salary = "";
$error = "";

// Check if the `id` is provided in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch employee details to pre-fill the form
    try {
        $sql = "SELECT * FROM employees WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Check if employee exists
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $name = $row['Name'];
            $address = $row['Address'];
            $salary = $row['Salary'];
        } else {
            echo "No employee found with ID " . $id;
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid Request!";
    exit;
}

// Handle form submission for updating employee
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $salary = $_POST['salary'];

    // Validate the inputs (you can add more validations if needed)
    if (empty($name) || empty($address) || empty($salary)) {
        $error = "All fields are required.";
    } else {
        // Update the employee details
        try {
            $sql = "UPDATE employees SET Name = :name, Address = :address, Salary = :salary WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':salary', $salary);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                echo "Employee details updated successfully!";
                header("Location: index.php"); // Redirect back to the list after update
                exit;
            } else {
                $error = "Unable to update employee details.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
</head>
<body>
    <h1>Edit Employee</h1>
    <?php if (!empty($error)) { ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php } ?>
    <form action="edit.php?id=<?php echo $id; ?>" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"><br><br>
        
        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>"><br><br>
        
        <label for="salary">Salary:</label>
        <input type="text" name="salary" value="<?php echo htmlspecialchars($salary); ?>"><br><br>

        <input type="submit" value="Update Employee">
    </form>
    <a href="index.php">Go back to Employee List</a>
</body>
</html>
