<?php
// Include necessary files
include '../includes/sidebar.php';
include '../includes/header.php';
include '../connection.php'; // Ensure this file sets up the $conn variable correctly

// Check if the database connection is established
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch totals
$totalPolls = $conn->query("SELECT COUNT(*) as total FROM polls")->fetch_assoc()['total'] ?? 0;
$activePolls = $conn->query("SELECT COUNT(*) as total FROM polls WHERE end_date >= CURDATE()")->fetch_assoc()['total'] ?? 0;
$totalUsers = $conn->query("SELECT COUNT(*) as total FROM prayojan")->fetch_assoc()['total'] ?? 0;

// Fetch trending polls
$trendingPolls = $conn->query("
    SELECT polls.question AS title, prayojan.name AS created_by, 
           SUM(votes) AS total_votes, polls.status 
    FROM polls
    JOIN prayojan ON polls.user_id = prayojan.id
    JOIN poll_options ON polls.id = poll_options.poll_id
    GROUP BY polls.id
    ORDER BY total_votes DESC
    LIMIT 5
");

// Fetch user status counts
$activeUsersQuery = $conn->query("SELECT COUNT(*) as total FROM prayojan WHERE last_active >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
$activeUsers = $activeUsersQuery->fetch_assoc()['total'] ?? 0;
$offlineUsers = $totalUsers - $activeUsers;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .chart-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .user-activity-chart {
            flex: 7;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .pie-chart {
            flex: 3;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .trending-container {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }
        /*  */
        .vertical-sections {
    flex: 2;
    display: flex;
    flex-direction: column;
    gap: 10px; /* Reduced gap between cards */
}

.card {
    display: flex;
    align-items: center; /* Aligns image and text in a single line */
    border-radius: 10px;
    padding: 10px;
    color: #fff;
    font-size: 14px; /* Adjusted font size for compact look */
    font-weight: bold;
    background-size: contain;
}

.card img {
    width: 50px; /* Reduced size of the image */
    height: 50px;
}

.card.blue { background-color: #007bff; }
.card.green { background-color: #28a745; }
.card.yellow { background-color: #ffc107; color: #333; }

        .trending-polls {
            flex: 6;
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
            <div class="chart-container">
                <div class="user-activity-chart">
                    <h5>Overall User Activity</h5>
                    <canvas id="userActivityChart"></canvas>
                </div>
                <div class="pie-chart">
                    <h5>User Pie Chart</h5>
                    <canvas id="userPieChart"></canvas>
                </div>
            </div>

            <div class="trending-container">
            <div class="vertical-sections">
    <div class="card blue">
        <div style="display: flex; align-items: center;">
            <img src="pollicon.png" alt="Total Polls">
            <div style="margin-left: 15px;">
                <span>Total Polls</span>
                <br>
                <span><?php echo $totalPolls; ?></span>
            </div>
        </div>
    </div>
    <div class="card green">
        <div style="display: flex; align-items: center;">
            <img src="pollicon.png" alt="Active Polls">
            <div style="margin-left: 15px;">
                <span>Active Polls</span>
                <br>
                <span><?php echo $activePolls; ?></span>
            </div>
        </div>
    </div>
    <div class="card yellow">
        <div style="display: flex; align-items: center;">
            <img src="pollicon.png" alt="Total Users">
            <div style="margin-left: 15px;">
                <span>Total Users</span>
                <br>
                <span><?php echo $totalUsers; ?></span>
            </div>
        </div>
    </div>
</div>

                <?php
                // Fetch trending polls
$trendingPolls = $conn->query("
    SELECT polls.question AS title, prayojan.name AS created_by, 
           SUM(poll_options.votes) AS total_votes, 
           CASE 
               WHEN polls.end_date >= CURDATE() THEN 'Active'
               ELSE 'Closed'
           END AS status
    FROM polls
    JOIN prayojan ON polls.user_id = prayojan.id
    JOIN poll_options ON polls.id = poll_options.poll_id
    GROUP BY polls.id, polls.question, prayojan.name, polls.end_date
    ORDER BY total_votes DESC
    LIMIT 3
");
?>

<!-- Trending Polls Table -->
<div class="trending-polls">
    <h5>Trending Polls</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Poll Title</th>
                <th>Created By</th>
                <th>Votes</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($trendingPolls && $trendingPolls->num_rows > 0): ?>
                <?php while ($poll = $trendingPolls->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($poll['title']); ?></td>
                        <td><?php echo htmlspecialchars($poll['created_by']); ?></td>
                        <td><?php echo $poll['total_votes']; ?></td>
                        <td><?php echo ucfirst($poll['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No trending polls available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


    <script>
        // User Activity Chart
        const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
        new Chart(userActivityCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'User Activity',
                    data: [100, 200, 150, 300, 400, 350, 500, 450, 400, 550, 600, 700],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0,123,255,0.1)',
                    fill: true
                }]
            },
            options: { responsive: true }
        });

        // User Status Pie Chart
        const userPieCtx = document.getElementById('userPieChart').getContext('2d');
        new Chart(userPieCtx, {
            type: 'pie',
            data: {
                labels: ['Active', 'Offline'],
                datasets: [{
                    data: [<?php echo $activeUsers; ?>, <?php echo $offlineUsers; ?>],
                    backgroundColor: ['#28a745', '#ffc107']
                }]
            },
            options: { responsive: true }
        });
    </script>
</body>
</html>
