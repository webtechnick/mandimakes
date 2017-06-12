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
        return sprintf('U$ %s', number_format($this->price(), 2));
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