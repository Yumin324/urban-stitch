<?php
require_once 'auth.php';
require_once '../config/database.php';
$pageTitle = 'Manage Products';

$message = '';
$message_type = '';

if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $delete = mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    if($delete) {
        $message = 'Product deleted successfully';
        $message_type = 'success';
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['action'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = floatval($_POST['price']);
        $category_id = intval($_POST['category_id']);
        $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);
        $stock = intval($_POST['stock']);
        
        if($_POST['action'] == 'create') {
            $sql = "INSERT INTO products (name, description, price, category_id, image_url, stock) 
                    VALUES ('$name', '$description', $price, $category_id, '$image_url', $stock)";
            if(mysqli_query($conn, $sql)) {
                $message = 'Product created successfully';
                $message_type = 'success';
            }
        } elseif($_POST['action'] == 'update') {
            $id = intval($_POST['id']);
            $sql = "UPDATE products SET name='$name', description='$description', price=$price, 
                    category_id=$category_id, image_url='$image_url', stock=$stock WHERE id=$id";
            if(mysqli_query($conn, $sql)) {
                $message = 'Product updated successfully';
                $message_type = 'success';
            }
        }
    }
}

$products = mysqli_query($conn, "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC");
$categories = mysqli_query($conn, "SELECT * FROM categories");

include 'includes/header.php';
?>

<?php if($message): ?>
    <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
<?php endif; ?>

<div class="admin-actions">
    <button class="btn btn-primary" onclick="openModal()">Add New Product</button>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($product = mysqli_fetch_assoc($products)): ?>
        <tr>
            <td><?php echo $product['id']; ?></td>
            <td><img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product" style="width: 50px; height: 50px; object-fit: cover;"></td>
            <td><?php echo htmlspecialchars($product['name']); ?></td>
            <td><?php echo htmlspecialchars($product['category_name']); ?></td>
            <td>LKR <?php echo number_format($product['price'], 2); ?></td>
            <td><?php echo $product['stock']; ?></td>
            <td>
                <button class="btn btn-sm btn-edit" onclick='editProduct(<?php echo json_encode($product); ?>)'>Edit</button>
                <a href="products.php?delete=<?php echo $product['id']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Add Product</h2>
        <form method="POST" action="products.php" class="admin-form">
            <input type="hidden" name="action" id="formAction" value="create">
            <input type="hidden" name="id" id="productId">
            
            <div class="form-group">
                <label for="name">Product Name *</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price (LKR) *</label>
                    <input type="number" id="price" name="price" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="stock">Stock *</label>
                    <input type="number" id="stock" name="stock" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="category_id">Category *</label>
                <select id="category_id" name="category_id" required>
                    <?php
                    mysqli_data_seek($categories, 0);
                    while($cat = mysqli_fetch_assoc($categories)):
                    ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="image_url">Image URL (Unsplash) *</label>
                <input type="url" id="image_url" name="image_url" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Save Product</button>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('productModal').style.display = 'flex';
    document.getElementById('modalTitle').textContent = 'Add Product';
    document.getElementById('formAction').value = 'create';
    document.getElementById('productId').value = '';
    document.querySelector('.admin-form').reset();
}

function closeModal() {
    document.getElementById('productModal').style.display = 'none';
}

function editProduct(product) {
    document.getElementById('productModal').style.display = 'flex';
    document.getElementById('modalTitle').textContent = 'Edit Product';
    document.getElementById('formAction').value = 'update';
    document.getElementById('productId').value = product.id;
    document.getElementById('name').value = product.name;
    document.getElementById('description').value = product.description;
    document.getElementById('price').value = product.price;
    document.getElementById('stock').value = product.stock;
    document.getElementById('category_id').value = product.category_id;
    document.getElementById('image_url').value = product.image_url;
}

window.onclick = function(event) {
    const modal = document.getElementById('productModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>
