<?php
namespace App\Models;
class BookCollection  { 
    private array $books = [];
   
    public function addBook(Book $book): self {
        $this->books[$book->id] = $book;
        return $this;
    }
    public function findById(int $id): ?Book {
        return $this->books[$id] ?? null;
        
    }
    public static function getBooks(): array {
        return self::$books;
    }
    public function count(): int {
        return \count($this->books);
    }
    public function __toString():string
    {
        $result = array_map(fn($book) => (string) $book, $this->books);
        return implode("\n", $result);
    }
}