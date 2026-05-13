<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Book;
use App\Helpers\LibraryHelper;

// Sample data - Reverted to match original constructor order: title, author, price, stock, id
$books = [
    new Book("Dune", "Frank Herbert", 25.99, 10, 1),
    new Book("1984", "George Orwell", 15.50, 5, 2),
    new Book("Animal Farm", "George Orwell", 12.00, 8, 3),
    new Book("The Hobbit", "J.R.R. Tolkien", 20.00, 3, 4),
    new Book("Foundation", "Isaac Asimov", 18.75, 12, 5),
];

echo "--- Testing 4a: formatTitle ---\n";
$titles = [' dune ', 'THE  GREAT  GATSBY', '  war and PEACE '];
foreach ($titles as $t) {
    echo "'$t' -> '" . LibraryHelper::formatTitle($t) . "'\n";
}

echo "\n--- Testing 4b: filterByAuthor (George Orwell) ---\n";
$orwellBooks = LibraryHelper::filterByAuthor($books, 'George Orwell');
foreach ($orwellBooks as $b) {
    echo $b->summary() . "\n";
}

echo "\n--- Testing 4c: sortByPrice (asc) ---\n";
$sortedAsc = LibraryHelper::sortByPrice($books, 'asc');
foreach ($sortedAsc as $b) {
    echo $b->summary() . "\n";
}

echo "\n--- Testing 4d: totalValue ---\n";
echo "Total Value: $" . LibraryHelper::totalValue($books) . "\n";

echo "\n--- Testing 4e: searchByKeyword ('her') ---\n";
$searchResult = LibraryHelper::searchByKeyword($books, 'her');
foreach ($searchResult as $b) {
    echo $b->summary() . "\n";
}
