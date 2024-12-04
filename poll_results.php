<?php
include 'connection.php';
include 'sidebar.php';

// Fetch user details
$email = $_SESSION['email'];
$sql = "SELECT * FROM prayojan WHERE email='$email'";
$result = $conn->query($sql);

if ($result === false) {
    die("Error: " . $conn->error);
}

$user = $result->fetch_assoc();
$profile_pic = $user['profile_pic'] ?? 'uploads/default_profile.png';

// Handle search functionality
$search_query = $_GET['search'] ?? '';
$poll_query = $search_query ? "SELECT * FROM polls WHERE question LIKE '%$search_query%'" : "SELECT * FROM polls";
$polls = $conn->query($poll_query);

// Fetch poll vote timestamps for timeline chart
$timeline_sql = "
    SELECT polls.question, COUNT(votes.id) as vote_count, DATE_FORMAT(votes.created_at, '%Y-%m-%d %H:%i') as vote_time
    FROM votes
    JOIN polls ON votes.poll_id = polls.id
    GROUP BY vote_time, polls.id
    ORDER BY vote_time ASC";
$timeline_data = $conn->query($timeline_sql);

$timeline_chart_data = [];
while ($row = $timeline_data->fetch_assoc()) {
    $timeline_chart_data[] = [
        'time' => $row['vote_time'],
        'votes' => $row['vote_count']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poll Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f9f9f9;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
        }
        .poll-overview {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #e9ecef;
            padding: 10px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .poll-insight {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            display: flex;
            flex-wrap: wrap;
        }
        .poll-details {
            flex: 1;
            min-width: 300px;
            padding-right: 20px;
        }
        .poll-chart {
            flex: 1;
            min-width: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .poll-chart canvas {
            max-height: 300px;
        }
        .poll-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .progress {
            height: 25px;
            background-color: #e9ecef;
            border-radius: 15px;
        }
        .progress-bar {
            background-color: #36A2EB;
        }
        .timeline-chart-container {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            display: none;
        }
        .timeline-chart-container canvas {
            width: 100%;
            height: 300px;
        }
        .search-bar {
            display: flex;
            align-items: center;
        }
        .search-bar input {
            margin-right: 10px;
            padding: 8px;
            width: 250px;
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="content">
    <h2 class="text-center">Poll Results</h2>

    <!-- Poll Overview -->
    <div class="poll-overview">
        <div>
            <strong>Engaged Participants:</strong> <span>1 out of 1</span>
        </div>
        <div class="search-bar">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search Polls" value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <div>
            <button class="btn btn-outline-dark" id="togglePieChart">Pie Chart</button>
            <button class="btn btn-outline-dark" id="toggleTimeline">Timeline</button>
        </div>
    </div>

    <!-- Timeline Chart -->
    <div class="timeline-chart-container" id="timelineChartContainer">
        <canvas id="timelineLineChart"></canvas>
    </div>

    <!-- Poll Insights -->
    <div id="poll-insights">
        <?php while ($poll = $polls->fetch_assoc()): ?>
            <div class="poll-insight">
                <div class="poll-details">
                    <div class="poll-title"><?php echo htmlspecialchars($poll['question']); ?></div>
                    <?php
                    $poll_id = $poll['id'];
                    $options_sql = "SELECT * FROM poll_options WHERE poll_id = $poll_id";
                    $options = $conn->query($options_sql);
                    $total_votes = 0;
                    while ($option = $options->fetch_assoc()) {
                        $total_votes += $option['votes'];
                    }
                    $options->data_seek(0);
                    ?>
                    <?php while ($option = $options->fetch_assoc()): ?>
                        <?php $percentage = $total_votes > 0 ? round(($option['votes'] / $total_votes) * 100, 2) : 0; ?>
                        <div class="mb-3">
                            <div class="progress">
                                <div class="progress-bar" style="width: <?php echo $percentage; ?>%;"><?php echo $percentage; ?>%</div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="poll-chart">
                    <canvas id="pieChart<?php echo $poll_id; ?>"></canvas>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script>
    // Timeline Chart Data
    const timelineData = <?php echo json_encode($timeline_chart_data); ?>;
    const labels = timelineData.map(item => item.time);
    const votes = timelineData.map(item => item.votes);

    // Timeline Line Chart
    const ctxTimeline = document.getElementById('timelineLineChart').getContext('2d');
    new Chart(ctxTimeline, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Votes Over Time',
                data: votes,
                borderColor: '#36A2EB',
                fill: false
            }]
        },
        options: {
            scales: {
                x: { title: { display: true, text: 'Time' } },
                y: { title: { display: true, text: 'Votes' }, beginAtZero: true }
            }
        }
    });

    // Toggle Pie Chart and Timeline View
    document.getElementById('togglePieChart').addEventListener('click', () => {
        document.getElementById('poll-insights').style.display = 'block';
        document.getElementById('timelineChartContainer').style.display = 'none';
    });
    document.getElementById('toggleTimeline').addEventListener('click', () => {
        document.getElementById('poll-insights').style.display = 'none';
        document.getElementById('timelineChartContainer').style.display = 'block';
    });

    <?php
    $polls->data_seek(0);
    while ($poll = $polls->fetch_assoc()):
        $poll_id = $poll['id'];
        $options_sql = "SELECT * FROM poll_options WHERE poll_id = $poll_id";
        $options = $conn->query($options_sql);
        $labels = [];
        $votes = [];
        while ($option = $options->fetch_assoc()) {
            $labels[] = htmlspecialchars($option['option_text']);
            $votes[] = $option['votes'];
        }
    ?>
    const ctx<?php echo $poll_id; ?> = document.getElementById('pieChart<?php echo $poll_id; ?>').getContext('2d');
    new Chart(ctx<?php echo $poll_id; ?>, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                data: <?php echo json_encode($votes); ?>,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
            }]
        }
    });
    <?php endwhile; ?>
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
