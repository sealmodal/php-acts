<?php
$books = [
    ['title' => 'The Midnight Library', 'author' => 'Matt Haig', 'genre' => 'Fiction', 
    'price' => 985.42, 'stock' => 18, 'rating' => 4.7, 'image' => 'images/ALICE.jpg'],

    ['title' => 'Lessons in Chemistry', 'author' => 'Bonnie Garmus', 'genre' => 'Historical Fiction', 
    'price' => 1101.42, 'stock' => 7, 'rating' => 4.6, 'image' => 'images/EMBERS RISING.jpg'],

    ['title' => 'Fourth Wing', 'author' => 'Rebecca Yarros', 'genre' => 'Fantasy', 
    'price' => 1275.42, 'stock' => 3, 'rating' => 4.5, 'image' => 'assets/fourth_wing.jpg'],

    ['title' => 'Tomorrow, and Tomorrow, and Tomorrow', 'author' => 'Gabrielle Zevin', 'genre' => 'Literary Fiction', 
    'price' => 869.42, 'stock' => 22, 'rating' => 4.8, 'image' => 'images/SIRENS.jpg'],

    ['title' => 'The Covenant of Water', 'author' => 'Abraham Verghese', 'genre' => 'Historical Fiction', 
    'price' => 1449.42, 'stock' => 14, 'rating' => 4.9, 'image' => 'assets/covenant.jpg'],

    ['title' => 'Happy Place', 'author' => 'Emily Henry', 'genre' => 'Romance', 
    'price' => 811.42, 'stock' => 0, 'rating' => 4.4, 'image' => 'assets/happy_place.jpg'],

    ['title' => 'Holly', 'author' => 'Stephen King', 'genre' => 'Thriller', 
    'price' => 1159.42, 'stock' => 9, 'rating' => 4.3, 'image' => 'assets/holly.jpg'],

    ['title' => 'Intermezzo', 'author' => 'Sally Rooney', 'genre' => 'Literary Fiction', 
    'price' => 1391.42, 'stock' => 16, 'rating' => 4.1, 'image' => 'assets/intermezzo.jpg'],
];

include('header_admin.php');
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 class="page-title">Book Catalog</h1>
        <p>8 titles in catalog</p>
    </div>
    <button class="btn btn--primary">+ Add Book</button>
</div>

<div class="header__search" style="margin-bottom: 25px; background: white; padding: 10px; border-radius: 8px;">
    <input type="text" id="bookSearch" onkeyup="filterBooks()" placeholder="Search books by title or author..." 
    style="width: 100%; border: none; outline: none;">
</div>

<div class="table-wrapper">
    <table class="orders-table" id="booksTable">
        <thead>
            <tr>
                <th>Book</th>
                <th>Genre</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Rating</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
            <tr>
                <td style="display: flex; align-items: center; gap: 15px;">
                    <img src="<?= htmlspecialchars($book['image']) ?>" 
                         alt="<?= htmlspecialchars($book['title']) ?>" 
                         style="width: 50px; height: 75px; object-fit: cover; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div>
                        <strong class="book-title" style="display: block; font-family: var(--font-heading);"><?= htmlspecialchars($book['title']) ?></strong>
                        <small class="book-author" style="color: var(--color-text-light);"><?= htmlspecialchars($book['author']) ?></small>
                    </div>
                </td>
                <td>
                    <span style="background: var(--color-bg-soft); padding: 4px 8px; border-radius: 4px; font-size: 12px;
                     color: var(--color-primary); font-weight: 600;">
                        <?= $book['genre'] ?>
                    </span>
                </td>
                <td style="font-weight: 700;">₱<?= number_format($book['price'], 2) ?></td>
                <td>
                    <span style="color: <?= $book['stock'] == 0 ? '#d9534f' : 'var(--color-success)' ?>; font-weight: bold;">
                        <?= $book['stock'] > 0 ? $book['stock'] . ' units' : 'Out of stock' ?>
                    </span>
                </td>
                <td><span style="color: #f39c12;">★</span> <?= $book['rating'] ?></td>
                <td style="text-align: right;">
                    <a href="delete_book.php?title=<?= urlencode($book['title']) ?>" 
                       style="color: #d9534f;" 
                       onclick="return confirm('Are you sure you want to delete <?= addslashes($book['title']) ?>?');">
                       <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function filterBooks() {
    let input = document.getElementById("bookSearch").value.toLowerCase();
    let table = document.getElementById("booksTable");
    let rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        let title = rows[i].querySelector(".book-title").innerText.toLowerCase();
        let author = rows[i].querySelector(".book-author").innerText.toLowerCase();
        
        if (title.includes(input) || author.includes(input)) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}
</script>

<?php 
echo '</main></div></body></html>'; 
?>