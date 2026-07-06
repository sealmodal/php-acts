<?php
$customers = [
    ['initials' => 'EA', 'name' => 'Elsa Anna', 'email' => 'anna@gmail.com', 'joined' => 'June 2026', 'orders' => 30, 'spent' => '₱2,500', 'status' => 'active'],
    ['initials' => 'MS', 'name' => 'Marie Swift', 'email' => 'swift@gmail.com', 'joined' => 'July 2024', 'orders' => 350, 'spent' => '₱2,500', 'status' => 'inactive'],
    ['initials' => 'KA', 'name' => 'Kaye Anne', 'email' => 'kaye@gmail.com', 'joined' => 'May 2025', 'orders' => 200, 'spent' => '₱2,500', 'status' => 'active'],
    ['initials' => 'MM', 'name' => 'Michelle Meyer', 'email' => 'meyer@gmail.com', 'joined' => 'January 2026', 'orders' => 45, 'spent' => '₱2,500', 'status' => 'inactive'],
    ['initials' => 'SG', 'name' => 'Selena Gomez', 'email' => 'gomez@gmail.com', 'joined' => 'August 2025', 'orders' => 150, 'spent' => '₱2,500', 'status' => 'active'],
    ['initials' => 'HB', 'name' => 'Hailey Bieber', 'email' => 'bieber@gmail.com', 'joined' => 'March 2023', 'orders' => 400, 'spent' => '₱2,500', 'status' => 'active'],
];

include('header_admin.php'); 
?>

<h1 class="page-title">Customers</h1>
<p class="page-subtitle">6 total Customers</p>

<div class="filters">
    <div class="search-wrapper" style="position: relative; width: 300px;">
        <input type="text" id="customerSearch" placeholder="Search customers..." 
               style="width: 100%; padding: 10px 10px 10px 35px; border: 1px solid var(--color-border); border-radius: 4px;">
        <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--color-text-light);"></i>
    </div>
</div>

<div class="table-wrapper">
    <table class="orders-table">
        <thead>
            <tr>
                <th>CUSTOMER</th>
                <th>JOINED</th>
                <th>ORDERS</th>
                <th>TOTAL SPENT</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $c): ?>
            <tr>
                <td style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: var(--color-primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: var(--font-heading); font-weight: bold;">
                        <?php echo $c['initials']; ?>
                    </div>
                    <div>
                        <div style="font-weight: 700;"><?php echo $c['name']; ?></div>
                        <div style="font-size: 12px; color: var(--color-text-light);"><?php echo $c['email']; ?></div>
                    </div>
                </td>
                <td><?php echo $c['joined']; ?></td>
                <td><?php echo $c['orders']; ?></td>
                <td style="font-weight: 700;"><?php echo $c['spent']; ?></td>
                <td>
                    <span class="badge <?php echo $c['status'] === 'active' ? 'shipped' : 'pending'; ?>">
                        <?php echo $c['status']; ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
document.querySelector('input[type="text"]').addEventListener('keyup', function() {
    let searchTerm = this.value.toLowerCase();
    let tableRows = document.querySelectorAll('.orders-table tbody tr');

    tableRows.forEach(row => {
        let rowText = row.textContent.toLowerCase();
        
        if (rowText.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

</main> </div> </body>
</html>