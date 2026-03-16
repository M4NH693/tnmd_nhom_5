<div class="page-header">
    <h1><i class="fas fa-chart-pie"></i> Dashboard</h1>
    <span style="color:var(--admin-text-muted);font-size:0.9rem;">
        <i class="fas fa-calendar"></i> <?= date('d/m/Y') ?>
    </span>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-book"></i></div>
        <div class="stat-info">
            <h3><?= number_format($totalBooks) ?></h3>
            <p>Tổng sách</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-users"></i></div>
        <div class="stat-info">
            <h3><?= number_format($totalUsers) ?></h3>
            <p>Người dùng</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-shopping-bag"></i></div>
        <div class="stat-info">
            <h3><?= number_format($totalOrders) ?></h3>
            <p>Đơn hàng</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-info">
            <h3><?= number_format($totalRevenue, 0, ',', '.') ?>₫</h3>
            <p>Doanh thu</p>
        </div>
    </div>
</div>

<!-- Revenue Chart + Top Books -->
<div class="grid-3">
    <div class="admin-card">
        <div class="admin-card-header">
            <h3><i class="fas fa-chart-bar"></i> Doanh thu hàng tháng</h3>
        </div>
        <div class="admin-card-body">
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <h3><i class="fas fa-fire"></i> Sách bán chạy</h3>
        </div>
        <div class="admin-card-body" style="padding:0;">
            <table class="admin-table">
                <thead><tr><th>Sách</th><th>Đã bán</th></tr></thead>
                <tbody>
                <?php if (!empty($topBooks)): foreach ($topBooks as $b): ?>
                <tr>
                    <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        <?= htmlspecialchars($b->title) ?>
                    </td>
                    <td><strong><?= $b->total_sold ?></strong></td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="2" style="text-align:center;color:var(--admin-text-muted);">Chưa có dữ liệu</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="admin-card" style="margin-top:20px;">
    <div class="admin-card-header">
        <h3><i class="fas fa-clock"></i> Đơn hàng gần đây</h3>
        <a href="<?= BASE_URL ?>/admin/orders" class="admin-btn admin-btn-outline admin-btn-sm">Xem tất cả</a>
    </div>
    <div class="admin-card-body" style="padding:0;">
        <table class="admin-table">
            <thead><tr><th>Mã đơn</th><th>Khách hàng</th><th>Tổng</th><th>Trạng thái</th><th>Ngày</th></tr></thead>
            <tbody>
            <?php if (!empty($recentOrders)): foreach ($recentOrders as $o):
                $stMap = ['pending'=>'badge-pending','confirmed'=>'badge-confirmed','shipping'=>'badge-shipping','delivered'=>'badge-delivered','cancelled'=>'badge-cancelled'];
                $stLabel = ['pending'=>'Chờ','confirmed'=>'Xác nhận','shipping'=>'Giao','delivered'=>'Hoàn thành','cancelled'=>'Hủy'];
            ?>
            <tr>
                <td><strong><?= $o->order_code ?></strong></td>
                <td><?= htmlspecialchars($o->full_name) ?></td>
                <td style="color:var(--admin-danger);font-weight:600;"><?= number_format($o->total_amount, 0, ',', '.') ?>₫</td>
                <td><span class="admin-badge <?= $stMap[$o->order_status] ?? '' ?>"><?= $stLabel[$o->order_status] ?? $o->order_status ?></span></td>
                <td style="color:var(--admin-text-muted);"><?= date('d/m/Y', strtotime($o->ordered_at)) ?></td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="5" style="text-align:center;color:var(--admin-text-muted);">Chưa có đơn hàng</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Revenue Chart Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('<?= BASE_URL ?>/admin/revenue-data')
        .then(r => r.json())
        .then(data => {
            const labels = data.map(d => 'T' + d.m + '/' + d.y);
            const revenues = data.map(d => parseFloat(d.revenue));
            const orders = data.map(d => parseInt(d.orders));

            new Chart(document.getElementById('revenueChart'), {
                type: 'bar',
                data: {
                    labels: labels.length ? labels : ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'],
                    datasets: [
                        {
                            label: 'Doanh thu (₫)',
                            data: revenues.length ? revenues : [0,0,0,0,0,0,0,0,0,0,0,0],
                            backgroundColor: 'rgba(45, 106, 79, 0.8)',
                            borderColor: '#2D6A4F',
                            borderWidth: 2,
                            borderRadius: 6,
                            barPercentage: 0.6,
                        },
                        {
                            label: 'Số đơn hàng',
                            data: orders.length ? orders : [0,0,0,0,0,0,0,0,0,0,0,0],
                            backgroundColor: 'rgba(233, 196, 106, 0.7)',
                            borderColor: '#E9C46A',
                            borderWidth: 2,
                            borderRadius: 6,
                            barPercentage: 0.6,
                            yAxisID: 'y1',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    plugins: {
                        legend: { position: 'top', labels: { usePointStyle: true, padding: 16, font: { family: 'Inter', size: 12 } } },
                        tooltip: {
                            backgroundColor: '#1E1E2D',
                            titleFont: { family: 'Inter' },
                            bodyFont: { family: 'Inter' },
                            padding: 12, cornerRadius: 8,
                            callbacks: {
                                label: function(ctx) {
                                    if (ctx.datasetIndex === 0) return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(ctx.raw) + '₫';
                                    return 'Đơn hàng: ' + ctx.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#F0F0F0' }, ticks: { font: { family: 'Inter', size: 11 }, callback: v => new Intl.NumberFormat('vi-VN',{notation:'compact'}).format(v) } },
                        y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false }, ticks: { font: { family: 'Inter', size: 11 } } },
                        x: { grid: { display: false }, ticks: { font: { family: 'Inter', size: 11 } } }
                    }
                }
            });
        })
        .catch(() => {
            // Fallback: show empty chart
            new Chart(document.getElementById('revenueChart'), {
                type: 'bar',
                data: { labels: ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'],
                        datasets: [{ label: 'Doanh thu (₫)', data: [0,0,0,0,0,0,0,0,0,0,0,0], backgroundColor: 'rgba(45,106,79,0.8)', borderRadius: 6, barPercentage: 0.6 }] },
                options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true }, x: { grid: { display: false } } } }
            });
        });
});
</script>
