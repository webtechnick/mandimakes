<?php

namespace App\Traits;

trait FormattedPrice
{
    /**
     * Formatted price with dollar sign.
     * @return [type] [description]
     */
    public function formattedPrice()
    {
        if ($this->price() == 0) {
            return 'Free';
        }
        return sprintf('$&nbsp;%s', number_format($this->price(), 2));
    }

    /**
     * Wrapper for helper function format_price in app_helpers.php
     * @param  [type] $price [description]
     * @return [type]        [description]
     */
    public function formatPrice($price)
    {
        return format_price($price);
    }

    /**
     * Price of item, formatted.
     * @return [type] [description]
     */
    public function localFormattedPrice()
    {
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        return money_format('%.2n', $this->price());
    }

    abstract function price();
}