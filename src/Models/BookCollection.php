<?php
namespace src\Models;
class BookCollection extends Book { 
    private array $books = [];
   
    public function addBook(Book $book): self {
        $this->books[$book->id] = $book;
        return $this;
    }
    public function findById(int $id): ?Book {
        return $this->books[$id] ?? null;
        
    }
    public function getBooks(): array {
        return $this->books;
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