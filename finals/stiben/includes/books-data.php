<?php
/**
 * The Literary Nook - Bookstore Management System
 * File: includes/books-data.php (Centralized Book Data)
 *
 * Single source of truth for all book data used across the site.
 * Both books.php (catalog) and book-detail.php (single book) pull from here.
 *
 * PLACEHOLDER: This entire array will be replaced by a DB query once
 * the admin CRUD pages (admin/books.php) are built and MySQL is wired up.
 * Example replacement:
 *   $books = $pdo->query("SELECT * FROM books")->fetchAll();
 *
 * Each book has:
 *   id          - unique identifier, used in URLs: book-detail.php?id=1
 *   title       - full book title
 *   author      - author name
 *   price       - price in PHP (float)
 *   badge       - optional label: "Bestseller", "New", "Sale", or ""
 *   genre       - used for filtering on books.php
 *   format      - physical or digital format of the book
 *   isbn        - placeholder ISBN number
 *   publisher   - publisher name
 *   year        - publication year
 *   description - lorem ipsum placeholder, will be real copy in production
 *   img         - placeholder image filename (all point to placeholder_book.jpg for now)
 *                 In production: real cover image filenames uploaded via admin CRUD
 */

$books = [
    [
        'id'          => 1,
        'title'       => 'The Midnight Library',
        'author'      => 'Matt Haig',
        'price'       => 549.00,
        'badge'       => 'Bestseller',
        'genre'       => 'Fiction',
        'format'      => 'Paperback',
        'isbn'        => '978-0-525-55947-4',
        'publisher'   => 'Viking',
        'year'        => 2020,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.',
        'img'         => 'placeholder_book.jpg',
        'stock'       => 12,
    ],
    [
        'id'          => 2,
        'title'       => 'Lessons in Chemistry',
        'author'      => 'Bonnie Garmus',
        'price'       => 620.00,
        'badge'       => 'New',
        'genre'       => 'Fiction',
        'format'      => 'Hardcover',
        'isbn'        => '978-0-385-54734-8',
        'publisher'   => 'Doubleday',
        'year'        => 2022,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        'img'         => 'placeholder_book.jpg',
        'stock'       => 8,
    ],
    [
        'id'          => 3,
        'title'       => 'Tomorrow, and Tomorrow, and Tomorrow',
        'author'      => 'Gabrielle Zevin',
        'price'       => 590.00,
        'badge'       => '',
        'genre'       => 'Fiction',
        'format'      => 'Paperback',
        'isbn'        => '978-0-593-32110-2',
        'publisher'   => 'Knopf',
        'year'        => 2022,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
        'img'         => 'placeholder_book.jpg',
        'stock'       => 5,
    ],
    [
        'id'          => 4,
        'title'       => 'Iron Flame',
        'author'      => 'Rebecca Yarros',
        'price'       => 750.00,
        'badge'       => 'Sale',
        'genre'       => 'Fantasy',
        'format'      => 'Hardcover',
        'isbn'        => '978-1-649-37460-6',
        'publisher'   => 'Red Tower Books',
        'year'        => 2023,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        'img'         => 'placeholder_book.jpg',
        'stock'       => 20,
    ],
    [
        'id'          => 5,
        'title'       => 'Happy Place',
        'author'      => 'Emily Henry',
        'price'       => 480.00,
        'badge'       => '',
        'genre'       => 'Romance',
        'format'      => 'Paperback',
        'isbn'        => '978-0-593-44122-8',
        'publisher'   => 'Berkley',
        'year'        => 2023,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
        'img'         => 'placeholder_book.jpg',
        'stock'       => 15,
    ],
    [
        'id'          => 6,
        'title'       => 'Fourth Wing',
        'author'      => 'Rebecca Yarros',
        'price'       => 720.00,
        'badge'       => 'Bestseller',
        'genre'       => 'Fantasy',
        'format'      => 'Hardcover',
        'isbn'        => '978-1-649-37454-5',
        'publisher'   => 'Red Tower Books',
        'year'        => 2023,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
        'img'         => 'placeholder_book.jpg',
        'stock'       => 3,
    ],
    [
        'id'          => 7,
        'title'       => 'Demon Copperhead',
        'author'      => 'Barbara Kingsolver',
        'price'       => 610.00,
        'badge'       => '',
        'genre'       => 'Fiction',
        'format'      => 'Paperback',
        'isbn'        => '978-0-063-23929-4',
        'publisher'   => 'Harper',
        'year'        => 2022,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor reprehenderit in voluptate velit esse cillum dolore.',
        'img'         => 'placeholder_book.jpg',
        'stock'       => 7,
    ],
    [
        'id'          => 8,
        'title'       => 'Intermezzo',
        'author'      => 'Sally Rooney',
        'price'       => 530.00,
        'badge'       => 'New',
        'genre'       => 'Fiction',
        'format'      => 'Hardcover',
        'isbn'        => '978-0-374-61066-1',
        'publisher'   => 'Farrar, Straus and Giroux',
        'year'        => 2024,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit.',
        'img'         => 'placeholder_book.jpg',
        'stock'       => 10,
    ],
    [
        'id'          => 9,
        'title'       => 'The Women',
        'author'      => 'Kristin Hannah',
        'price'       => 699.00,
        'badge'       => 'Bestseller',
        'genre'       => 'Historical Fiction',
        'format'      => 'Hardcover',
        'isbn'        => '978-1-250-31786-3',
        'publisher'   => 'St. Martin\'s Press',
        'year'        => 2024,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'img'         => 'placeholder_book.jpg',
        'stock'       => 18,
    ],
    [
        'id'          => 10,
        'title'       => 'A Court of Thorns and Roses',
        'author'      => 'Sarah J. Maas',
        'price'       => 460.00,
        'badge'       => '',
        'genre'       => 'Fantasy',
        'format'      => 'Paperback',
        'isbn'        => '978-1-619-63512-7',
        'publisher'   => 'Bloomsbury',
        'year'        => 2015,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.',
        'img'         => 'placeholder_book.jpg',
        'stock'       => 25,
    ],
    [
        'id'          => 11,
        'title'       => 'Spare',
        'author'      => 'Prince Harry',
        'price'       => 580.00,
        'badge'       => 'Sale',
        'genre'       => 'Biography',
        'format'      => 'Paperback',
        'isbn'        => '978-0-593-59321-7',
        'publisher'   => 'Random House',
        'year'        => 2023,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.',
        'img'         => 'placeholder_book.jpg',
        'stock'       => 6,
    ],
    [
        'id'          => 12,
        'title'       => 'Atomic Habits',
        'author'      => 'James Clear',
        'price'       => 520.00,
        'badge'       => 'Bestseller',
        'genre'       => 'Self-Help',
        'format'      => 'Paperback',
        'isbn'        => '978-0-735-21129-2',
        'publisher'   => 'Avery',
        'year'        => 2018,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate.',
        'img'         => 'placeholder_book.jpg',
        'stock'       => 30,
    ],
];

// -------------------------------------------------------
// Helper: find a single book by its ID.
// Used by book-detail.php to look up ?id= from the URL.
// In production: SELECT * FROM books WHERE id = ?
// -------------------------------------------------------
function find_book_by_id(array $books, int $id): ?array {
    foreach ($books as $book) {
        if ($book['id'] === $id) {
            return $book;
        }
    }
    return null; // returns null if ID doesn't match any book
}

// -------------------------------------------------------
// Helper: get all unique genres from the books array.
// Used by books.php to build the genre filter buttons.
// In production: SELECT DISTINCT genre FROM books
// -------------------------------------------------------
function get_genres(array $books): array {
    $genres = [];
    foreach ($books as $book) {
        if (!in_array($book['genre'], $genres)) {
            $genres[] = $book['genre'];
        }
    }
    sort($genres);
    return $genres;
}
