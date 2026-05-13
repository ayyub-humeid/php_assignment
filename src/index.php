<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Helpers\CsvReader;
use App\Models\Book;
use App\Models\BookCollection;
use App\Helpers\ReportWriter;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elancer Library Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./public/app.css">
    
</head>
<body>
    <div class="container">
        <header>
            <h1>Library Hub</h1>
            <p style="color: var(--text-dim)">Professional Inventory Management System</p>
        </header>

        <div class="section">
            <h2>Initial Collection</h2>
            <?php
            $collection = new BookCollection();
            $book1 = new Book("The Great Gatsby", "F. Scott Fitzgerald", 10.99, 1, 5);
            $book2 = new Book("To Kill a Mockingbird", "Harper Lee", 8.99, 2, 3);
            $collection->addBook($book1)->addBook($book2);
            
            foreach ([$book1, $book2] as $book) {
                echo "<div class='book-item'>";
                echo "<span><strong>{$book->title}</strong> by {$book->author}</span>";
                echo "<span class='badge'>\${$book->price} • {$book->stock} units</span>";
                echo "</div>";
            }
            ?>
        </div>

        <div class="section">
            <h2>Activity Log</h2>
            <div class="log-entry">
                Applying 20% discount to 'The Great Gatsby'...
                <?php
                try {
                    $newPrice = $book1->applyDiscount(20);
                    echo " <span class='success'>New price: \${$newPrice}</span>";
                } catch (\Exception $e) { echo " Error: " . $e->getMessage(); }
                ?>
            </div>
            <div class="log-entry">
                Checking out 'To Kill a Mockingbird'...
                <?php
                try {
                    $book2->checkout();
                    echo " <span class='success'>Success! Remaining stock: {$book2->stock}</span>";
                } catch (\Exception $e) { echo " Error: " . $e->getMessage(); }
                ?>
            </div>
        </div>

        <div class="section">
            <h2>Imported CSV Catalog</h2>
            <?php
            $booksFromCsv = CsvReader::load(__DIR__ . '/Data/Books.csv');
            foreach ($booksFromCsv as $book) {
                echo "<div class='book-item'>";
                echo "<span><strong>{$book->title}</strong> by {$book->author}</span>";
                echo "<span class='badge' style='background: " . ($book->stock > 0 ? "rgba(34, 197, 94, 0.1)" : "rgba(244, 63, 94, 0.1)") . "; color: " . ($book->stock > 0 ? "var(--success)" : "#fb7185") . "'>";
                echo "\${$book->price} • " . ($book->stock > 0 ? "{$book->stock} in stock" : "Out of stock") . "</span>";
                echo "</div>";
            }
            ?>
        </div>

        <div class="section" style="text-align: center; border: 1px dashed var(--accent); background: transparent;">
            <?php
            ReportWriter::write($booksFromCsv, __DIR__ . '/../report.txt');
            echo "<p style='color: var(--accent); font-weight: 600; margin: 0;'>✓ Inventory Report Generated Successfully</p>";
            ?>
        </div>
    </div>
</body>
</html>
