<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">
<h2>Task List</h2>

<div class="table-container">
<table>
  <thead>
  <tr>
    <th>ID</th>
    <th>NAME</th>
    <th>SUBJECT</th>
    <th>TASK</th>
    <th>DATE CREATED</th>
    <th>ACTIONS</th>
  </tr>
  </thead>
  <tbody>
  <?php
    $result = $conn->query("SELECT * FROM tasks");
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['subject']) . "</td>
                <td>" . htmlspecialchars($row['task']) . "</td>
                <td>{$row['date_created']}</td>
                <td>
                  <button class='btn edit-btn' onclick=\"openEditModal({$row['id']}, '" . htmlspecialchars($row['name'], ENT_QUOTES) . "', '" . htmlspecialchars($row['subject'], ENT_QUOTES) . "', '" . htmlspecialchars($row['task'], ENT_QUOTES) . "')\">Edit</button>
                  <button class='btn delete-btn' onclick=\"openDeleteModal({$row['id']})\">Delete</button>
                </td>
              </tr>";
    }
  ?>
  </tbody>
</table>
</div>

<!-- Button Container -->
<div class="button-container">
  <button id="addBtn" class="btn add-btn">Add Data</button>
  <a href="index.php" class="btn back-btn">Back to Index</a>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeAdd">&times;</span>
    <h2>Add New Task</h2>
    <form action="insert_task.php" method="POST">
      <label>Name:</label>
      <input type="text" name="name" placeholder="Enter name" required>
      
      <label>Subject:</label>
      <input type="text" name="subject" placeholder="Enter subject" required>
      
      <label>Task:</label>
      <textarea name="task" placeholder="Enter task description" required></textarea>
      
      <input type="submit" value="Add Task">
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeEdit">&times;</span>
    <h2>Edit Task</h2>
    <form id="editForm" action="edit_task.php" method="POST">
      <input type="hidden" name="id" id="editId">
      
      <label>Name:</label>
      <input type="text" name="name" id="editName" required>
      
      <label>Subject:</label>
      <input type="text" name="subject" id="editSubject" required>
      
      <label>Task:</label>
      <textarea name="task" id="editTask" required></textarea>
      
      <input type="submit" value="Update Task">
    </form>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
  <div class="modal-content delete-modal-content">
    <span class="close" id="closeDelete">&times;</span>
    <h2>Delete Task</h2>
    <p>Are you sure you want to delete this task?</p>
    <div class="modal-buttons">
      <button class="confirm-delete-btn" id="confirmDelete">OK</button>
      <button class="cancel-delete-btn" id="cancelDelete">Cancel</button>
    </div>
  </div>
</div>

<script>
  let deleteTaskId = null;

  // Add Data Modal
  const addBtn = document.getElementById("addBtn");
  const addModal = document.getElementById("addModal");
  const closeAdd = document.getElementById("closeAdd");

  addBtn.onclick = () => addModal.style.display = "flex";
  closeAdd.onclick = () => addModal.style.display = "none";

  // Edit Modal
  const editModal = document.getElementById("editModal");
  function openEditModal(id, name, subject, task) {
    document.getElementById("editId").value = id;
    document.getElementById("editName").value = name;
    document.getElementById("editSubject").value = subject;
    document.getElementById("editTask").value = task;
    editModal.style.display = "flex";
  }
  document.getElementById("closeEdit").onclick = () =>
    editModal.style.display = "none";

  // Delete Modal
  const deleteModal = document.getElementById("deleteModal");
  const closeDelete = document.getElementById("closeDelete");
  const confirmDelete = document.getElementById("confirmDelete");
  const cancelDelete = document.getElementById("cancelDelete");

  function openDeleteModal(id) {
    deleteTaskId = id;
    deleteModal.style.display = "flex";
  }

  closeDelete.onclick = () => {
    deleteModal.style.display = "none";
    deleteTaskId = null;
  };

  cancelDelete.onclick = () => {
    deleteModal.style.display = "none";
    deleteTaskId = null;
  };

  confirmDelete.onclick = () => {
    if (deleteTaskId) {
      window.location.href = `delete_task.php?id=${deleteTaskId}`;
    }
  };

  // Close modals when clicking outside
  window.onclick = (e) => {
    if (e.target === addModal) addModal.style.display = "none";
    if (e.target === editModal) editModal.style.display = "none";
    if (e.target === deleteModal) {
      deleteModal.style.display = "none";
      deleteTaskId = null;
    }
  };
</script>
</body>
</html>