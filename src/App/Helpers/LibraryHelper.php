<?php

namespace App\Helpers;

use App\Models\Book;

class LibraryHelper {
    /**
     * 4a: Trim whitespace, convert to title case, and collapse internal spaces.
     */
    public static function formatTitle(string $title): string {
        $title = trim($title);
        $title = preg_replace('/\s+/', ' ', $title);
        return ucwords(strtolower($title));
    }

    /**
     * 4b: Filter books by author (case-insensitive).
     */
    public static function filterByAuthor(array $books, string $author): array {
        $filtered = array_filter($books, function (Book $book) use ($author) {
            return strtolower($book->author) === strtolower($author);
        });
        return array_values($filtered);
    }

    /**
     * 4c: Sort books by price.
     */
    public static function sortByPrice(array $books, string $dir = 'asc'): array {
        usort($books, function (Book $a, Book $b) use ($dir) {
            if ($dir === 'desc') {
                return $b->price <=> $a->price;
            }
            return $a->price <=> $b->price;
        });
        return $books;
    }

    /**
     * 4d: Sum of (price x stock) using array_reduce.
     */
    public static function totalValue(array $books): float {
        return array_reduce($books, function ($carry, Book $book) {
            return $carry + ($book->price * $book->stock);
        }, 0.0);
    }

    /**
     * 4e: Search books by keyword in title or author (case-insensitive).
     */
    public static function searchByKeyword(array $books, string $kw): array {
        $kw = strtolower($kw);
        $filtered = array_filter($books, function (Book $book) use ($kw) {
            return str_contains(strtolower($book->title), $kw) || 
                   str_contains(strtolower($book->author), $kw);
        });
        return array_values($filtered);
    }
}
