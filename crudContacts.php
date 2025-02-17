<?php
include 'databaseConfig.php';

// Create Contact (Add)
function createContact($firstName, $lastName, $email, $phone) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO contacts (name, last_name, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $firstName, $lastName, $phone);
    return $stmt->execute();
}

// Read All Contacts
function getAllContacts() {
    global $conn;
    $result = $conn->query("SELECT * FROM contacts");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Update Contact
function updateContact($id, $firstName, $lastName, $phone) {
    global $conn;
    $stmt = $conn->prepare("UPDATE contacts SET name = ?, last_name = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("sssi", $firstName, $lastName, $phone, $id);
    return $stmt->execute();
}

// Delete Contact
function deleteContact($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
