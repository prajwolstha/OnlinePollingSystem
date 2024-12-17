<?php
include '../includes/sidebar.php';
include '../includes/header.php';
include '../connection.php';

// Establish database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Simulate user activity: Update last_active column for a logged-in user (replace with real user ID)
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $updateLastActive = "UPDATE prayojan SET last_active = NOW() WHERE id = $userId";
    mysqli_query($conn, $updateLastActive);
}

// Initialize the search query
$searchQuery = "";
if (isset($_GET['search']) && trim($_GET['search']) != '') {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT * FROM prayojan WHERE name LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%'";
} else {
    $query = "SELECT * FROM prayojan";
}

// Apply role filter if present
$roleFilter = $_GET['role'] ?? '';
if ($roleFilter) {
    $query .= " AND role = '" . mysqli_real_escape_string($conn, $roleFilter) . "'";
}

// Execute the query
$users = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .main-container {
            display: flex;
        }
        .sidebar {
            width: 250px;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header-bar h1 {
            font-size: 24px;
            margin: 0;
        }
        .search-box {
            position: relative;
            width: 300px;
        }
        .search-box input {
            width: 100%;
            padding: 8px 10px;
            border-radius: 20px;
            border: 1px solid #ccc;
        }
        .tabs {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        .tabs a {
            text-decoration: none;
            padding: 10px 20px;
            background: #f0f0f0;
            border-radius: 5px;
            color: #333;
        }
        .tabs a.active {
            background: #007bff;
            color: #fff;
        }
        .table-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <?php include '../includes/sidebar.php'; ?>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="header-bar">
                <h1>Manage Users</h1>
                <div class="search-box">
                    <form method="GET" action="">
                        <input type="text" name="search" placeholder="Search users..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                    </form>
                </div>
            </div>

            <!-- Tabs -->
            <div class="tabs">
                <a href="manage_users.php" class="<?php echo !$roleFilter ? 'active' : ''; ?>">All Users</a>
                <a href="manage_users.php?role=admin" class="<?php echo $roleFilter === 'admin' ? 'active' : ''; ?>">Admin</a>
                <a href="manage_users.php?role=registered" class="<?php echo $roleFilter === 'registered' ? 'active' : ''; ?>">Registered</a>
                <a href="manage_users.php?role=guest" class="<?php echo $roleFilter === 'guest' ? 'active' : ''; ?>">Guests</a>
            </div>

            <!-- Users Table -->
            <div class="table-container">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role(s)</th>
                            <th>Add Date</th>
                            <th>Last Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($users && mysqli_num_rows($users) > 0): ?>
                        <?php while ($user = mysqli_fetch_assoc($users)): ?>
                            <tr>
                                <td><?php echo $user['name'] ?? 'N/A'; ?></td>
                                <td><?php echo $user['email'] ?? 'N/A'; ?></td>
                                <td><?php echo $user['role'] ?? 'N/A'; ?></td>
                                <td><?php echo $user['created_at'] ?? 'N/A'; ?></td>
                                <td><?php echo $user['last_active'] ?? 'N/A'; ?></td>
                                <td>
                                    <a href="block_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to block this user?');">Block User</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No users found.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
