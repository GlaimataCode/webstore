<?php
declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;
use Illuminate\Support\Number;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\DataCollectionOf;

class CartData extends Data
{
    #[Computed]
    public float $total;

    public int $total_weight;

    public int $total_quantity;

    public string $total_formatted;

    public function __construct(
        #[DataCollectionOf(CartItemData::class)]
        public DataCollection $items
    ) {
        $collection = $items->toCollection();
        $this->total = $collection->sum(fn(CartItemData $item) => $item->price * $item->quantity);
        $this->total_weight = $collection->sum(fn(CartItemData $item) => $item->weight ?? 0);
        $this->total_quantity = $collection->sum(fn(CartItemData $item) => $item->quantity);
        $this->total_formatted = Number::currency($this->total);
    }
}
