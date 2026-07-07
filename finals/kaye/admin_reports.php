<?php include('header_admin.php'); ?>

<h1 class="page-title">Reports</h1>

<p class="page-subtitle">Analytics and business summaries.</p>

<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
    <?php foreach(['Total Revenue', 'Total Orders', 'Avg Order Value', 'Total Customers'] as $stat): ?>
    <div class="table-wrapper" style="text-align: center;">
        <div class="summary-label"><?php echo $stat; ?></div>
        <div class="summary-number">₱2,500</div>
    </div>
    <?php endforeach; ?>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
    <div class="table-wrapper">
        <h3 style="font-family: var(--font-heading); margin-bottom: 15px;">Monthly Orders</h3>
        <canvas id="monthlyOrdersChart"></canvas>
    </div>
    <div class="table-wrapper">
        <h3 style="font-family: var(--font-heading); margin-bottom: 15px;">Revenue vs Orders</h3>
        <canvas id="revenueOrdersChart"></canvas>
    </div>
</div>

<div class="table-wrapper">
    <h3 style="font-family: var(--font-heading); margin-bottom: 15px;">Inventory Levels</h3>
    <canvas id="inventoryChart" style="max-height: 300px;"></canvas>
</div>

<div style="
display:flex;
justify-content:center;
gap:25px;
margin-top:15px;
font-size:14px;
">

    <span>
        <span style="
        width:14px;
        height:14px;
        display:inline-block;
        background:#3E6B3A;
        border-radius:50%;
        margin-right:8px;"></span>
        Healthy
    </span>

    <span>
        <span style="
        width:14px;
        height:14px;
        display:inline-block;
        background:#F1C40F;
        border-radius:50%;
        margin-right:8px;"></span>
        Low Stock
    </span>

    <span>
        <span style="
        width:14px;
        height:14px;
        display:inline-block;
        background:#FF3B30;
        border-radius:50%;
        margin-right:8px;"></span>
        Out of Stock
    </span>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
Chart.defaults.font.family = "'Poppins', sans-serif";
Chart.defaults.color = "#555";

/* ======================
   MONTHLY ORDERS
====================== */
new Chart(document.getElementById('monthlyOrdersChart'), {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        datasets: [{
            label: 'Orders',
            data: [240, 180, 120, 60, 20],
            backgroundColor: '#3E6B3A',
            borderRadius: 8,
            hoverBackgroundColor: '#4f874a'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#3E6B3A'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#e5e5e5'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        },
        animation: {
            duration: 1500
        }
    }
});


/* ======================
   REVENUE VS ORDERS
====================== */
new Chart(document.getElementById('revenueOrdersChart'), {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [
            {
                label: 'Revenue',
                data: [4000, 5500, 7000, 6500, 9000, 11500],
                borderColor: '#2d5a31',
                backgroundColor: 'rgba(62,107,58,0.08)',
                fill: true,
                tension: 0.4,
                yAxisID: 'y'
            },
            {
                label: 'Orders',
                data: [80, 110, 140, 130, 180, 240],
                borderColor: '#F1C40F',
                backgroundColor: '#F1C40F',
                tension: 0.4,
                yAxisID: 'y1'
            }
        ]
    },
    options: {
        responsive: true,
        interaction: {
            intersect: false,
            mode: 'index'
        },
        plugins: {
            tooltip: {
                mode: 'index'
            }
        },
        scales: {
            y: {
                position: 'left',
                beginAtZero: true,
                ticks: {
                    callback: value => '₱' + value
                }
            },
            y1: {
                position: 'right',
                beginAtZero: true,
                grid: {
                    drawOnChartArea: false
                }
            }
        }
    }
});


/* ======================
   INVENTORY LEVELS
====================== */

const inventoryData = [20, 70, 90, 45, 65, 40];

const colors = inventoryData.map(stock => {
    if (stock <= 25) return '#FF3B30';  // Out of Stock
    if (stock <= 50) return '#F1C40F';  // Low Stock
    return '#3E6B3A';                   // Healthy
});

new Chart(document.getElementById('inventoryChart'), {
    type: 'bar',
    data: {
        labels: [
            "Omniscient Reader's Viewpoint",
            "The Beginning After The End",
            "Like Wind on a Dry Branch",
            "Solo Leveling",
            "The Villainess Turns The Hourglass",
            "Greatest Estate Developer"
        ],
        datasets: [{
            label: 'Stock',
            data: inventoryData,
            backgroundColor: colors,
            borderRadius: 6
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let value = context.raw;

                        if(value <= 25)
                            return value + ' - Out of Stock';

                        if(value <= 50)
                            return value + ' - Low Stock';

                        return value + ' - Healthy';
                    }
                }
            },
            legend: {
                display: false
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});
</script>

<div class="table-wrapper" style="margin-top: 20px;">
    <h3 style="font-family: var(--font-heading); margin-bottom: 20px;">Customer Activity</h3>
    <table class="orders-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; color: var(--color-text-light); border-bottom: 1px solid var(--color-border);">
                <th style="padding: 12px 0;">Customer</th>
                <th style="padding: 12px 0;">Action</th>
                <th style="padding: 12px 0;">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $activities = [
                ['name' => 'Elsa Anna', 'action' => 'Purchased "The Midnight Library"', 'date' => 'July 07, 2026'],
                ['name' => 'Marie Swift', 'action' => 'Added "Fourth Wing" to wishlist', 'date' => 'July 07, 2026'],
                ['name' => 'Kaye Anne', 'action' => 'Left a review for "Happy Place"', 'date' => 'July 06, 2026'],
                ['name' => 'Michelle Meyer', 'action' => 'Added two books of "Like Wind on a Dry Branch to wishlist', 'date' => 'July 06, 2026'],
                ['name' => 'Selena Gomez', 'action' => 'Purchased "Solo Leveling"', 'date' => 'July 05, 2026'],
                ['name' => 'Hailey', 'action' => 'Registered a new account', 'date' => 'July 05, 2026']
            ];

            foreach ($activities as $act): ?>
            <tr style="border-bottom: 1px solid var(--color-bg-soft);">
                <td style="padding: 15px 0; font-weight: 600; color: var(--color-text);"><?= $act['name'] ?></td>
                <td style="padding: 15px 0; color: var(--color-text-light);"><?= $act['action'] ?></td>
                <td style="padding: 15px 0; color: var(--color-text-light); font-size: 0.9em;"><?= $act['date'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</main> 
</div> 
</body>
</html>