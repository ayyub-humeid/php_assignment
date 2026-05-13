<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Helpers\CsvReader;
use App\Helpers\LibraryHelper;
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
    <style>
        :root {
            --bg: #0f172a;
            --card-bg: #1e293b;
            --accent: #38bdf8;
            --text: #f8fafc;
            --text-dim: #94a3b8;
            --success: #22c55e;
            --warning: #f59e0b;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            max-width: 900px;
            width: 100%;
        }
        header {
            text-align: center;
            margin-bottom: 50px;
        }
        h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 3rem;
            margin: 0;
            background: linear-gradient(to right, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .section {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 16px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .section:hover {
            transform: translateY(-2px);
        }
        h2 {
            font-size: 1.25rem;
            color: var(--accent);
            margin-top: 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
        }
        .book-item {
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .book-item:last-child { border-bottom: none; }
        .log-entry {
            font-family: monospace;
            padding: 8px 12px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 6px;
            margin: 5px 0;
            border-left: 3px solid var(--accent);
        }
        .success { border-left-color: var(--success); color: var(--success); }
        .badge {
            background: rgba(56, 189, 248, 0.1);
            color: var(--accent);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>
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
