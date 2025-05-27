<?php
require_once 'db_connect.php';
require_once 'header.php';

// Fetch menu items
$stmt = $pdo->query("SELECT * FROM menu_items ORDER BY category, name");
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="text-2xl font-bold mb-4">Our Menu</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <?php foreach ($menu_items as $item): ?>
        <div class="bg-white rounded-lg shadow-md p-4">
            <?php if ($item['image']): ?>
                <img src="<?php echo htmlspecialchars($item['image']); ?>" class="w-full h-48 object-cover rounded-t-lg" alt="<?php echo htmlspecialchars($item['name']); ?>">
            <?php endif; ?>
            <div class="p-4">
                <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($item['name']); ?></h3>
                <p class="text-gray-600"><?php echo htmlspecialchars($item['description']); ?></p>
                <p class="text-gray-800 font-bold mt-2">$<?php echo number_format($item['price'], 2); ?></p>
                <p class="text-gray-500 text-sm"><?php echo htmlspecialchars($item['category']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once 'footer.php'; ?>