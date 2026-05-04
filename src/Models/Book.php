<?php
namespace App\Models;

use App\Contracts\Discountable;
use App\Models\Timestampable;
class Book implements Discountable {
    use Timestampable;
   
    public function applyDiscount(float $pct): float
    {
        // $discountAmount = $this->price * ($pct / 100);
        // $this->price -= $discountAmount;
        // return $this->price;
        if($pct < 0 || $pct > 100){
            throw new \InvalidArgumentException("Discount percentage must be between 0 and 100");
        }
            $discountAmount = $this->price * ($pct / 100);
            $this->price -= $discountAmount;
            return $this->price;
    }
public function __construct(
public string $title,
 public string $author,
 public float $price,
 public int $stock = 0,
   readonly int $id,
) {
    $this->initTimestamps();
}
public function summary(): string {

// return  "${id} ${title} by {author} — ${price} ({stock} in stock)"
return "[$this->id] $this->title by $this->author —\$$this->price ($this->stock in stock) ";
}
public function isAvailable(): bool {
return $this->stock > 0 ;
}
public function checkout(): void {

if($this->stock <=0){
    throw new \Exception("Book is out of stock");
}
$this->stock--;
}
public function __toString()
{
    return $this->summary();
}
}