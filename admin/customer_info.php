<?php 
require('../config/autoload.php'); 
include("header.php");

// Create a new DataAccess object
$dao = new DataAccess();

// Query to get all customer information
$sqlCustomers = "SELECT * FROM customer";
$customerResults = $dao->query($sqlCustomers); // Ensure your DataAccess class has a `query` method

// Check if customer results are valid
if ($customerResults === false) {
    echo "<p>Error fetching customers: " . $dao->error . "</p>";
    $customerResults = []; // Initialize to an empty array to avoid foreach errors
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information</title>
    <style>
        /* Basic styles for the table */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h1>Customer Information</h1>

<table>
    <thead>
        <tr>
            <?php if (!empty($customerResults)): ?>
                <?php foreach (array_keys($customerResults[0]) as $column): ?>
                    <th><?php echo htmlspecialchars($column); ?></th>
                <?php endforeach; ?>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customerResults as $customer): ?>
            <tr>
                <?php foreach ($customer as $value): ?>
                    <td><?php echo htmlspecialchars($value); ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>

<?php 
// Close the DataAccess connection if needed
?>
