<?php
require_once 'db_connect.php';
require_once 'header.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = '';

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Insert into database
    $stmt = $pdo->prepare("INSERT INTO menu_items (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $category, $image]);
}

// Fetch menu items
$stmt = $pdo->query("SELECT * FROM menu_items");
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="text-2xl font-bold mb-4">Manage Menu</h2>
<form method="post" enctype="multipart/form-data" class="mb-6 space-y-4">
    <div>
        <label for="name" class="block text-sm font-medium">Name</label>
        <input type="text" id="name" name="name" required class="w-full p-2 border rounded">
    </div>
    <div>
        <label for="description" class="block text-sm font-medium">Description</label>
        <textarea id="description" name="description" class="w-full p-2 border rounded"></textarea>
    </div>
    <div>
        <label for="price" class="block text-sm font-medium">Price</label>
        <input type="number" step="0.01" id="price" name="price" required class="w-full p-2 border rounded">
    </div>
    <div>
        <label for="category" class="block text-sm font-medium">Category</label>
        <select id="category" name="category" required class="w-full p-2 border rounded">
            <option value="Appetizer">Appetizer</option>
            <option value="Main Course">Main Course</option>
            <option value="Dessert">Dessert</option>
            <option value="Beverage">Beverage</option>
        </select>
    </div>
    <div>
        <label for="image" class="block text-sm font-medium">Image</label>
        <input type="file" id="image" name="image" class="w-full p-2 border rounded">
    </div>
    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Add Item</button>
</form>

<h3 class="text-xl font-semibold mb-2">Menu Items</h3>
<table class="w-full border-collapse border">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">Name</th>
            <th class="border p-2">Price</th>
            <th class="border p-2">Category</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($menu_items as $item): ?>
            <tr>
                <td class="border p-2"><?php echo htmlspecialchars($item['name']); ?></td>
                <td class="border p-2">$<?php echo number_format($item['price'], 2); ?></td>
                <td class="border p-2"><?php echo htmlspecialchars($item['category']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'footer.php'; ?>