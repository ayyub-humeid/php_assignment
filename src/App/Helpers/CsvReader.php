<?php
namespace App\Helpers;
use App\Models\Book;
class CsvReader {
    public static function load(string $path): array {
        $books = [];

        $file = fopen($path, 'r');
        if (!$file) return $books;

        fgetcsv($file, null, ",", '"', "\\"); // skip header row

        while (($row = fgetcsv($file, null, ",", '"', "\\")) !== false) {
            $books[] = new Book($row[1], $row[2], (float)$row[3], (int)$row[0], (int)$row[4]);
        }

        fclose($file);
        return $books;
    }
}