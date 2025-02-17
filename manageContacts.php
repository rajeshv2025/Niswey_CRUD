<?php
include 'crudContacts.php';
include 'databaseConfig.php';


// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        createContact($_POST['name'], $_POST['last_name'], $_POST['phone']);
    } elseif (isset($_POST['update'])) {
        updateContact($_POST['id'], $_POST['name'], $_POST['last_name'], $_POST['phone']);
    }
}

// Delete a contact
if (isset($_GET['delete'])) {
    deleteContact($_GET['delete']);
}

// Fetch contacts
$contacts = getAllContacts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Management</title>
</head>
<body>

<?php
if (isset($_GET['edit']) ? $_GET['edit'] : ''){ 
echo "<h2>Contact Management</h2>";


$eid = $_GET['edit'];
$ret=mysqli_query($conn,"select * from contacts where id='$eid'");
while ($row=mysqli_fetch_array($ret)) {
?>
<h3>Update Contact</h3>
<!-- Form to Update Contacts -->
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="id" value="<?= isset($_GET['edit']) ? $_GET['edit'] : '' ?>">
    <label>First Name:</label><br>
    <input type="text" name="name" value = "<?php echo $row['name']; ?>" required><br><br>
    
    <label>Last Name:</label><br>
    <input type="text" name="last_name" value = "<?php echo $row['last_name']; ?>" required><br><br>
    
    
    <label>Phone:</label><br>
    <input type="text" name="phone" value = "<?php echo $row['phone']; ?>" required><br><br>
   
    <button type="submit" name="<?= isset($_GET['edit']) ? 'update' : 'create' ?>">Submit</button>
    <?php 
     } }?>
</form>

<!-- Contact List -->
<h3>Contacts</h3>
<table border="1">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contacts as $contact): ?>
        <tr>
            <td><?= $contact['name'] ?></td>
            <td><?= $contact['last_name'] ?></td>
            <td><?= $contact['phone'] ?></td>
            <td>
                <a href="?edit=<?= $contact['id'] ?>">Edit</a>
                <a href="?delete=<?= $contact['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Import Contacts via XML -->
<h3>Import Contacts from XML</h3>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="xml_file" accept=".xml" required>
    <button type="submit" name="import_xml">Import XML</button>
</form>

<?php
if (isset($_POST['import_xml']) && $_FILES['xml_file']['error'] == 0) {
    $xml_data = simplexml_load_file($_FILES['xml_file']['tmp_name']);
    //echo $xml_data;
    
		for($i = 0; $i < count($xml_data); $i++)
        
		{

            $name = $xml_data->contact[$i]->name;
            $last_name = $xml_data->contact[$i]->lastName;
            $phone = $xml_data->contact[$i]->phone;

			$sql = "INSERT INTO contacts (name, last_name, phone)
              VALUES ('".$name."', '".$last_name."', '".$phone."')";
         
           mysqli_query($conn, $sql);
		
 
		}
        echo $msg = "Contacts imported Succesfully!";
        header("Refresh:5");
		
}
?>

</body>
</html>
