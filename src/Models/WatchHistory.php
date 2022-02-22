<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Session;
use Nowyouwerkn\WeCommerce\Models\Product;

class WatchHistory
{
    public $items;

    public function __construct($oldRecommend)
    {
        if ($oldRecommend) {
            $this->items = $oldRecommend->items;
        }
    }

    public function add($item) 
    {         
        $storedItem = [
            'slug' => $item->slug,
            'category' => $item->category_id,
            'search_tags' => $item->search_tags
        ];

        if ($this->items) {
            if (array_key_exists($item->name, $this->items)) {
                $storedItem = $this->items[$item->name];
            }
        }

        $this->items[$item->name] = $storedItem;        
    }
}
