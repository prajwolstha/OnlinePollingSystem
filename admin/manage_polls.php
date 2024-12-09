<?php
include '../includes/sidebar.php';
include '../includes/header.php';
include '../connection.php';

// Handle search functionality
$searchQuery = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

// Fetch totals
$totalPolls = $conn->query("SELECT COUNT(*) AS total FROM polls")->fetch_assoc()['total'] ?? 0;
$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM prayojan")->fetch_assoc()['total'] ?? 0;
$activePolls = $conn->query("SELECT COUNT(*) AS total FROM polls WHERE end_date >= CURDATE()")->fetch_assoc()['total'] ?? 0;

// Fetch polls for Project Overview
$pollsOverviewQuery = "
    SELECT polls.id, polls.question AS project_title, polls.created_at AS created_date,
           prayojan.name AS created_by, 
           SUM(poll_options.votes) AS votes, 
           CASE 
               WHEN polls.end_date >= CURDATE() THEN 'Active'
               ELSE 'Closed'
           END AS status
    FROM polls
    JOIN prayojan ON polls.user_id = prayojan.id
    JOIN poll_options ON polls.id = poll_options.poll_id
";

if (!empty($searchQuery)) {
    $pollsOverviewQuery .= " WHERE polls.question LIKE '%$searchQuery%'";
}

$pollsOverviewQuery .= " GROUP BY polls.id ORDER BY polls.created_at DESC";
$pollsOverview = $conn->query($pollsOverviewQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Polls</title>
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
        .statistics {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .card {
            display: flex;
            align-items: center;
            padding: 15px;
            flex: 1;
            border-radius: 10px;
            color: #fff;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card img {
            width: 50px;
            height: 50px;
            margin-right: 15px;
        }
        .card.blue { background-color: #007bff; }
        .card.yellow { background-color: #ffc107; color: #333; }
        .card.green { background-color: #28a745; }
        .search-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .search-container input {
            flex: 1;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }
        .search-container button {
            margin-left: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .table-container {
            margin-top: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table thead th {
            background-color: #007bff;
            color: #fff;
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
            <!-- Search Polls -->
            <div class="search-container">
                <form method="get" action="">
                    <input type="text" name="search" placeholder="Search Polls..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <button type="submit">Search</button>
                </form>
            </div>

            <!-- Statistics -->
            <div class="statistics">
                <div class="card blue">
                    <img src="pollicon.png" alt="Total Polls">
                    <div>
                        <span>Total Polls</span>
                        <strong><?php echo $totalPolls; ?></strong>
                    </div>
                </div>
                <div class="card yellow">
                    <img src="pollicon.png" alt="Total Users">
                    <div>
                        <span>Total Users</span>
                        <strong><?php echo $totalUsers; ?></strong>
                    </div>
                </div>
                <div class="card green">
                    <img src="pollicon.png" alt="Active Polls">
                    <div>
                        <span>Active Polls</span>
                        <strong><?php echo $activePolls; ?></strong>
                    </div>
                </div>
            </div>

            <!-- Project Overview Table -->
            <div class="table-container">
                <h5>Project Overview</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Project Title</th>
                            <th>Created Date</th>
                            <th>Created By</th>
                            <th>Votes</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($pollsOverview && $pollsOverview->num_rows > 0): ?>
                            <?php while ($poll = $pollsOverview->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($poll['project_title']); ?></td>
                                    <td><?php echo htmlspecialchars($poll['created_date']); ?></td>
                                    <td><?php echo htmlspecialchars($poll['created_by']); ?></td>
                                    <td><?php echo $poll['votes']; ?></td>
                                    <td><?php echo ucfirst($poll['status']); ?></td>
                                    <td>
                                        <a href="view_poll.php?id=<?php echo $poll['id']; ?>" class="btn btn-primary btn-sm">View</a>
                                        <a href="delete_poll.php?id=<?php echo $poll['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this poll?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No polls found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
