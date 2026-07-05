<div class="container">
    <?php
    include('style.php');
    include('header.php');
    include('menu.php');

    echo '<div class="main mainmenu">';
    function renderMenu($items)
    {
        foreach ($items as $item) {
            echo "
                <div class='main-item'>
                    <div class='menu-img'>
                        <img src='{$item['img']}' alt='{$item['name']}'>
                    </div>
                    <div class='menu-text'>
                        <p><strong>{$item['name']}</strong> | {$item['price']}</p>
                    </div>
                </div>
            ";
        }
    }

    $drink = [
        ["img" => "images/drink-cappuccino.jpg", "name" => "Cappuccino", "price" => "₱90.00"],
        ["img" => "images/drink-macchiato.jpg", "name" => "Macchiato", "price" => "₱90.00"],
        ["img" => "images/drink-spanish.jpg", "name" => "Spanish Latte", "price" => "₱100.00"],
        ["img" => "images/drink-matcha.jpg", "name" => "Matcha Latte", "price" => "₱100.00"],
        ["img" => "images/drink-horchata.jpg", "name" => "Horchata", "price" => "₱100.00"],
        ["img" => "images/drink-tea.jpg", "name" => "Iced Tea", "price" => "₱70.00"],
    ];

    $food = [
        ["img" => "images/food-carbonara.jpg", "name" => "Carbonara", "price" => "₱170.00"],
        ["img" => "images/food-lasagna.jpg", "name" => "Classic Lasagna", "price" => "₱170.00"],
        ["img" => "images/food-sandwich.jpg", "name" => "Club Sandwich", "price" => "₱140.00"],
        ["img" => "images/food-carrot.jpg", "name" => "Carrot Cake", "price" => "₱120.00 (per slice)"],
        ["img" => "images/food-blueberry.jpg", "name" => "Blueberry Cheesecake", "price" => "₱120.00 (per slice)"],
        ["img" => "images/food-lemon.jpg", "name" => "Lemon Bars", "price" => "₱35.00 (per bar)"],
    ];

    
    echo '<h2 class="categ">Drinks</h2>';
    echo '<div class="content-wrapper">';
    renderMenu($drink);

    echo'</div><div class="divider"></div>';

    echo '<div class="content-wrapper">';
    echo '</div><h2 class="categ">Food</h2>';
    echo '<div class="content-wrapper">';
    renderMenu($food);

    echo '</div></div>';

    include('contact.php');
    ?>
</div>