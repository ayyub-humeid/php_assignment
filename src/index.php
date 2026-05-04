<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Models\Book;
use App\Models\BookCollection;
$collection = new BookCollection();
$book1 = new Book("The Great Gatsby", "F. Scott Fitzgerald", 10.99, 5, 1);
$book2 = new Book("To Kill a Mockingbird", "Harper Lee", 8.99, 3, 2);
$collection->addBook($book1)->addBook($book2);
echo $collection;
echo "\n\nApplying 20% discount to book 1...\n";
try {
    $newPrice = $book1->applyDiscount(20);
    echo "New price of '{$book1->title}': \$$newPrice\n";
} catch (\InvalidArgumentException $e) {
    echo "Error applying discount: " . $e->getMessage() . "\n";
}
echo "\nChecking out book 2...\n";
try {
    $book2->checkout();
    echo "Checked out '{$book2->title}'. Remaining stock: {$book2->stock}\n";
} catch (\Exception $e) {
    echo "Error checking out: " . $e->getMessage() . "\n";
}