<?php
$page_title = "My Orders";
require_once 'includes/header.php'; 

$orders = [
    [
        "id" => "ORD-2026-001",
        "date" => "June 30, 2026",
        "product" => "Omniscient Reader's Viewpoint x 1",
        "status" => "Delivered",
        "amount" => "₱2,500",
        "email" => "elsanna@gmail.com",
        "address" => "Quezon City, South Triangle, 1130",
        "proof" => "proof.jpg"
    ],
    [
        "id" => "ORD-2026-005",
        "date" => "June 30, 2026",
        "product" => "Omniscient Reader's Viewpoint x 2",
        "status" => "Shipped",
        "amount" => "₱4,500",
        "email" => "elsanna@gmail.com",
        "address" => "Quezon City, South Triangle, 1130",
        "proof" => "proof.jpg"
    ],

    [
        "id" => "ORD-2026-010",
        "date" => "July 5, 2026",
        "product" => "The Beginning After The End x 1",
        "status" => "Pending",
        "amount" => "₱650",
        "email" => "elsanna@gmail.com",
        "address" => "Quezon City, South Triangle, 1130",
        "proof" => ""
    ],
    [
        "id" => "ORD-2026-012",
        "date" => "July 8, 2026",
        "product" => "Solo Leveling x 1",
        "status" => "Confirmed",
        "amount" => "₱700",
        "email" => "elsanna@gmail.com",
        "address" => "Quezon City, South Triangle, 1130",
        "proof" => ""
    ]
];
?>

<main class="container" style="padding: 40px 0;">
    <h1 style="font-family: var(--font-heading);">MY ORDERS</h1>
    <p class="subtitle" style="color: var(--color-text-light); margin-bottom: 30px;">
        <?php echo count($orders); ?> orders in your history
    </p>

    <div class="orders-list">
        <?php foreach($orders as $order): ?>
        <div class="order-card" style="border: 1px solid var(--color-border); padding: 20px; border-radius: 8px; margin-bottom: 20px; background: white;">
            <div class="order-header" style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--color-bg-soft); 
            padding-bottom: 15px; margin-bottom: 15px;">
                <div>
                    <small style="color: var(--color-text-light);"><?php echo $order['id']; ?></small>
                    <h3 style="font-family: var(--font-heading); margin: 0;"><?php echo $order['date']; ?></h3>
                </div>
                <div class="header-right" style="text-align: right;">
                    <span class="status-badge" style="background: var(--color-success); color: white; 
                    padding: 4px 12px; border-radius: 20px; font-size: 0.9em;"><?php echo $order['status']; ?></span>

                    <strong style="display: block; margin-top: 8px;"><?php echo $order['amount']; ?></strong>
                </div>
            </div>
            <div class="order-body">
                <p style="margin: 0 0 10px 0; font-family: var(--font-body);"><?php echo $order['product']; ?></p>
                <button class="btn btn--primary" onclick="openDetails('<?php echo $order['id']; ?>', '<?php 
                echo $order['status']; ?>', '<?php echo $order['email']; ?>', '<?php echo $order['proof']; ?>')">
                    View Details
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div id="darkOverlay" onclick="closeDetails()" style=" display: none; position: fixed; top: 0; left: 0; 
    width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999; backdrop-filter: blur(2px);">
</div>
</main>

<div id="detailsPanel" class="details-panel" style=" background: var(--color-bg); padding: 40px; position: fixed; top: 0; 
    right: -600px; width: 600px;  height: 100%; overflow-y: auto; transition: 0.4s ease; z-index: 1000; box-shadow: var(--shadow-hover); 
    border-left: 2px solid var(--color-border);">

    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 25px;">
    <div>
        <h2 id="orderID" style="font-family: var(--font-heading); color: var(--color-primary); margin: 0;">ORD-000</h2>
        <p id="orderEmail" style="color: var(--color-text-light); font-size: 0.9em;"></p>
        <p id="orderDate" style="color: var(--color-text-light); font-size: 0.85em;"></p>
    </div>
    
    <div style="display: flex; align-items: center; gap: 15px;">
        <span id="headerStatusBadge" style="background: var(--color-success); color: white;
        padding: 4px 12px; border-radius: 20px; font-size: 0.8em; font-weight: bold; display: none;"></span>
        <button onclick="closeDetails()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: var(--color-text-light);">✕</button>
    </div>
</div>

    <h4 style="font-family: var(--font-heading); color: var(--color-primary); border-bottom: 2px solid var(--color-border); 
    padding-bottom: 5px; margin-bottom: 15px;">STATUS TIMELINES</h4>
    <div id="timelineContainer" style="margin-bottom: 30px;">
        </div>

    <h4 style="font-family: var(--font-heading); color: var(--color-primary); border-bottom: 2px solid var(--color-border); 
    padding-bottom: 5px; margin-bottom: 15px;">ORDERED ITEMS</h4>
    <div id="itemsContainer" style="margin-bottom: 25px;">
        </div>

    <div id="priceSummary" style="background: #fff; padding: 20px; border: 1px solid var(--color-border); border-radius: var(--radius-md);">
        </div>

    <h4 style="font-family: var(--font-heading); color: var(--color-primary); margin: 25px 0 15px 0;">PROOF OF DELIVERY</h4>
    <div class="proof-wrapper" onclick="openFullImageModal()" style="cursor: pointer; border-radius: var(--radius-md); overflow: hidden; 
    border: 2px solid var(--color-border);">

        <img src="" id="proofImage" style="width: 100%; display: block; aspect-ratio: 16/9; object-fit: cover;">
        <div style="background: var(--color-primary); color: white; text-align: center; 
        padding: 10px; font-family: var(--font-heading); font-size: 12px; letter-spacing: 0.05em;">👁 VIEW ALL</div>
    </div>
</div>

<script>

const orderData = {
    "ORD-2026-001": {
        status: "Delivered",
        email: "elsannaaa@gmail.com",
        date: "July 1, 2026",
        proof: "images/proof.jpg",
        timeline: [
            { stage: "Pending", date: "2026-06-27 5:52" },
            { stage: "Confirmed", date: "2026-06-28 10:52" },
            { stage: "Shipped", date: "2026-06-29 9:52" },
            { stage: "Delivered", date: "2026-07-01 9:52" }
        ],
        items: [
            { title: "Omniscient Reader's Viewpoint", price: 500, qty: 1, isbn: "978-0525559474" },
            { title: "Omniscient Reader's Viewpoint", price: 500, qty: 1, isbn: "978-0525559474" }
        ],
        discount: 50
    },
    "ORD-2026-005": {
        status: "Shipped",
        email: "elsannaaa@gmail.com",
        date: "June 30, 2026",
        proof: "proof.jpg",
        timeline: [
            { stage: "Pending", date: "2026-06-28 8:00" },
            { stage: "Confirmed", date: "2026-06-29 10:00" },
            { stage: "Shipped", date: "2026-06-30 14:00" }
        ],
        items: [
            { title: "Omniscient Reader's Viewpoint", price: 500, qty: 2, isbn: "978-0525559474" },
            { title: "The Beginning After The End", price: 650, qty: 1, isbn: "978-1975345678" }
        ],
        discount: 0
    },
    "ORD-2026-010": {
        status: "Pending",
        email: "elsannaaa@gmail.com",
        date: "July 5, 2026",
        proof: "",
        timeline: [
            { stage: "Pending", date: "2026-07-05 09:00" }
        ],
        items: [
            { title: "The Beginning After The End", price: 650, qty: 1, isbn: "978-1975345678" }
        ],
        discount: 0
    },
    "ORD-2026-012": {
        status: "Confirmed",
        email: "elsannaaa@gmail.com",
        date: "July 8, 2026",
        proof: "",
        timeline: [
            { stage: "Pending", date: "2026-07-08 10:00" },
            { stage: "Confirmed", date: "2026-07-08 14:00" }
        ],
        items: [
            { title: "Solo Leveling", price: 700, qty: 1, isbn: "978-0525559474" }
        ],
        discount: 0
    }
};

// Opens the side panel and fills it with order-specific data
function openDetails(id) {
    const data = orderData[id];
    document.getElementById("orderID").innerText = id;
    document.getElementById("orderEmail").innerText = data.email;
    document.getElementById("orderDate").innerText = `${data.status} ${data.date}`;
    
    const badge = document.getElementById("headerStatusBadge");
    badge.innerText = data.status.toUpperCase();
    badge.style.display = "block";
    badge.style.background = (data.status === "Delivered") ? "var(--color-success)" : "#888";

    // Builds the status timeline list
    const tl = document.getElementById("timelineContainer");
    tl.innerHTML = data.timeline.map(step => `
        <div style="padding-left: 20px; border-left: 2px solid var(--color-primary); margin-bottom: 10px; position: relative;">
            <div style="font-weight: 700; font-family: var(--font-heading); color: var(--color-text);">${step.stage}</div>
            <div style="font-size: 0.8em; color: var(--color-text-light);">${step.date}</div>
        </div>
    `).join('');

    // Lists all purchased items
    const items = document.getElementById("itemsContainer");
    items.innerHTML = data.items.map(item => `
        <div style="border: 1px solid var(--color-border); padding: 12px; margin-bottom: 10px; border-radius: var(--radius-sm);">
            <div style="font-weight: 700; font-family: var(--font-heading); font-size: 0.9em;">${item.title}</div>
            <div style="font-size: 0.8em; color: var(--color-text-light);">ISBN: ${item.isbn}</div>
            <div style="text-align: right; font-weight: 700; color: var(--color-primary);">₱${item.price} x ${item.qty}</div>
        </div>
    `).join('');

    // Displays the price breakdown
    const subtotal = data.items.reduce((sum, item) => sum + (item.price * item.qty), 0);
    document.getElementById("priceSummary").innerHTML = `
        <div style="display: flex; justify-content: space-between; font-family: var(--font-body);"><span>Subtotal</span> <span>₱${subtotal}</span></div>
        <div style="display: flex; justify-content: space-between; color: var(--color-success); font-weight: 700;"><span>Discount</span> <span>-₱${data.discount}</span></div>
        <hr style="border: 0; border-top: 1px solid var(--color-border); margin: 10px 0;">
        <div style="display: flex; justify-content: space-between; font-weight: 800; font-family: var(--font-heading);"><span>Total Paid</span> <span>₱${subtotal - data.discount}</span></div>
    `;

    // Shows delivery proof image if delivered, otherwise shows a notice
    const proofWrapper = document.querySelector(".proof-wrapper");
    if (data.status === "Delivered") {
        proofWrapper.style.cursor = "pointer";
        proofWrapper.style.pointerEvents = "auto";
        proofWrapper.innerHTML = `
            <img src="${data.proof}" id="proofImage" style="width: 100%; display: block; aspect-ratio: 16/9; object-fit: cover;">
            <div style="background: var(--color-primary); color: white; text-align: center; padding: 10px; font-family: var(--font-heading); font-size: 12px; letter-spacing: 0.05em;">👁 VIEW ALL</div>
        `;
    } else {
        proofWrapper.style.cursor = "default";
        proofWrapper.style.pointerEvents = "none";
        proofWrapper.innerHTML = `
            <div style="height: 150px; display: flex; align-items: center; justify-content: center; color: var(--color-text-light); font-family: var(--font-body); font-style: italic; background: var(--color-bg-soft);">
                Order is ${data.status}. Proof of delivery not available yet.
            </div>
        `;
    }

    document.getElementById("detailsPanel").style.right = "0";
    document.getElementById("darkOverlay").style.display = "block";
}

function closeDetails() {
    document.getElementById("detailsPanel").style.right = "-600px"; 
    
    if (document.getElementById("darkOverlay")) {
        document.getElementById("darkOverlay").style.display = "none";
    }
}

function openFullImageModal() {
    const imgSrc = document.getElementById("proofImage").src;
    
    let modal = document.getElementById("imageModal");
    if (!modal) {
        modal = document.createElement("div");
        modal.id = "imageModal";
        modal.style.cssText = "position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 2000; display: flex; align-items: center; justify-content: center; cursor: pointer;";
        modal.onclick = function() { this.style.display = 'none'; };
        document.body.appendChild(modal);
    }
    
    modal.innerHTML = `<img src="${imgSrc}" style="max-width: 90%; max-height: 90%; border: 3px solid white;">`;
    modal.style.display = "flex";
}
</script>

<?php require_once 'includes/footer.php'; ?>
