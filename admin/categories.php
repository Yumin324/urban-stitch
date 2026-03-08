<?php
require_once 'auth.php';
require_once '../config/database.php';
$pageTitle = 'Manage Categories';

$message = '';
$message_type = '';

if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $delete = mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
    if($delete) {
        $message = 'Category deleted successfully';
        $message_type = 'success';
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['action'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        
        if($_POST['action'] == 'create') {
            $sql = "INSERT INTO categories (name, description) VALUES ('$name', '$description')";
            if(mysqli_query($conn, $sql)) {
                $message = 'Category created successfully';
                $message_type = 'success';
            }
        } elseif($_POST['action'] == 'update') {
            $id = intval($_POST['id']);
            $sql = "UPDATE categories SET name='$name', description='$description' WHERE id=$id";
            if(mysqli_query($conn, $sql)) {
                $message = 'Category updated successfully';
                $message_type = 'success';
            }
        }
    }
}

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");

include 'includes/header.php';
?>

<?php if($message): ?>
    <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
<?php endif; ?>

<div class="admin-actions">
    <button class="btn btn-primary" onclick="openModal()">Add New Category</button>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($category = mysqli_fetch_assoc($categories)): ?>
        <tr>
            <td><?php echo $category['id']; ?></td>
            <td><?php echo htmlspecialchars($category['name']); ?></td>
            <td><?php echo htmlspecialchars($category['description']); ?></td>
            <td><?php echo date('M d, Y', strtotime($category['created_at'])); ?></td>
            <td>
                <button class="btn btn-sm btn-edit" onclick='editCategory(<?php echo json_encode($category); ?>)'>Edit</button>
                <a href="categories.php?delete=<?php echo $category['id']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure? This will affect products in this category.')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div id="categoryModal" class="modal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Add Category</h2>
        <form method="POST" action="categories.php" class="admin-form">
            <input type="hidden" name="action" id="formAction" value="create">
            <input type="hidden" name="id" id="categoryId">
            
            <div class="form-group">
                <label for="name">Category Name *</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Save Category</button>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('categoryModal').style.display = 'flex';
    document.getElementById('modalTitle').textContent = 'Add Category';
    document.getElementById('formAction').value = 'create';
    document.getElementById('categoryId').value = '';
    document.querySelector('.admin-form').reset();
}

function closeModal() {
    document.getElementById('categoryModal').style.display = 'none';
}

function editCategory(category) {
    document.getElementById('categoryModal').style.display = 'flex';
    document.getElementById('modalTitle').textContent = 'Edit Category';
    document.getElementById('formAction').value = 'update';
    document.getElementById('categoryId').value = category.id;
    document.getElementById('name').value = category.name;
    document.getElementById('description').value = category.description;
}

window.onclick = function(event) {
    const modal = document.getElementById('categoryModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>
