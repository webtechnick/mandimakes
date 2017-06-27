<?php

function format_price($float)
{
    return sprintf('$&nbsp;%s', number_format($float, 2));
}