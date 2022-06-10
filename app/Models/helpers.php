<?php

function presentPrice($price): string
{
    return 'E.P '.number_format($price / 100, 2);

}
