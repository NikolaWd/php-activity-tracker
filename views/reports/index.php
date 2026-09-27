<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/nav.php'; ?>

<h1>Reports</h1>

<?php if ($rows === []): ?>
    <p>No page views or button clicks recorded yet.</p>
<?php else: ?>
    <h2>Activity by date</h2>
    <div class="mb-4" style="height: 360px">
        <canvas id="activity-chart" role="img" aria-label="Daily counts for Page A, Page B, Buy a cow and Download"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const rows = <?= json_encode(
            $rows,
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR
        ) ?>;

        new Chart(document.getElementById('activity-chart'), {
            type: 'line',
            data: {
                labels: rows.map(row => row.date),
                datasets: [
                    {
                        label: 'Page A views',
                        data: rows.map(row => row.page_a),
                        borderColor: '#0d6efd'
                    },
                    {
                        label: 'Page B views',
                        data: rows.map(row => row.page_b),
                        borderColor: '#198754'
                    },
                    {
                        label: 'Buy a cow clicks',
                        data: rows.map(row => row.buy_cow),
                        borderColor: '#dc3545'
                    },
                    {
                        label: 'Download clicks',
                        data: rows.map(row => row.download),
                        borderColor: '#6f42c1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { title: { display: true, text: 'Date' } },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Count' },
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    </script>

    <h2>Daily totals</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr><th>Date</th><th>Page A views</th><th>Page B views</th><th>Buy a cow clicks</th><th>Download clicks</th></tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= e($row['date']) ?></td>
                        <td><?= e($row['page_a']) ?></td>
                        <td><?= e($row['page_b']) ?></td>
                        <td><?= e($row['buy_cow']) ?></td>
                        <td><?= e($row['download']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
