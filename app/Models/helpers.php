<?php

/**
 * @param $price
 * @return string
 */
function presentPrice($price): string
{
    return 'E.P '.number_format($price / 100, 2);
}

/**
 * @param $quantity
 * @return string
 */
function getInStock($quantity): string
{
    if ($quantity > setting('site.in_stock')){
        $inStock = 'In Stock';
    }elseif ($quantity < setting('site.in_stock') && $quantity > 0 )
    {
        $inStock = 'Low Stock';
    }else{
        $inStock = 'Not Available';
    }

    return $inStock;
}
