<?php
namespace App\Helpers;

class ReportWriter {
 public static function write(array $books, string $path): void {
    $file = fopen($path, 'w');
    if (!$file) return;

    foreach ($books as $book) {
        fwrite($file, $book->summary() . "\n");
    }

    $total = LibraryHelper::totalValue($books);
    fwrite($file, "Total inventory value: $" . number_format($total, 2) . "\n");

    fclose($file);
}
}
