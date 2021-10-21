<?php

namespace Nowyouwerkn\WeCommerce\Models;

use Session;
use Nowyouwerkn\WeCommerce\Models\Product;

class Cart
{
    public $items;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id, $variant, $price) 
    {         
        $storedItem = ['qty' => 0, 'price' => $price, 'variant' => $variant, 'item' => $item];

        $item_merged = ($id . ',' . $variant);

        if ($this->items) {
            if (array_key_exists($item_merged, $this->items)) {                
                $storedItem = $this->items[$item_merged];
            }
        }
        
        // Validador de Existencias
        $product = Product::find($id);

        $current_stock = $product->stock;
        $qty_on_cart = $storedItem['qty'];  

        if ($qty_on_cart < $current_stock) {
            $storedItem['qty']++;
            $storedItem['price'] = $price * $storedItem['qty'];
            $storedItem['variant'] = $variant;    

            $this->items[$item_merged] = $storedItem;

            $this->totalQty++;
            $this->totalPrice += $price;
        }

        Session::flash('error', 'No hay más existencias de este producto para agregar a tu carrito.');
    }

    public function addMore($id, $price, $variant)
    {
        $item_merged = ($id . ',' . $variant); 

        $this->items[$item_merged]['qty']++;
        $this->items[$item_merged]['price'] += $price;
        
        $this->totalQty++;
        $this->totalPrice += $price;

        if ($this->items[$item_merged]['qty'] <= 0 ) {
            unset($this->items[$id]);
        }
    }

    public function substractOne($id, $price, $variant)
    {
        $item_merged = ($id . ',' . $variant); 

        $this->items[$item_merged]['qty']--;
        $this->items[$item_merged]['price'] -= $price;

        $this->totalQty--;
        $this->totalPrice -= $price;

        if ($this->items[$item_merged]['qty'] <= 0 ) {
            unset($this->items[$item_merged]);
        }
    }

    public function deleteItem($id, $variant)
    {   
        $item_merged = ($id . ',' . $variant); 

        $this->totalQty -= $this->items[$item_merged]['qty'];
        $this->totalPrice -= $this->items[$item_merged]['price'];

        unset($this->items[$item_merged]);
    }
}
