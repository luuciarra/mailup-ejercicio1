<?php

    function decimalformat($number, $withSymbol = true)
    {
        $decimals = config("numberformat.decimals", 2);
        $dec_point = config("numberformat.dec_point", ",");
        $thousands_sep = config("numberformat.thousands_sep", ".");

        $format = number_format($number, $decimals, $dec_point, $thousands_sep);
        
        $format = str_replace("{$dec_point}00", '', $format);

        return $withSymbol ? "$".$format : $format;
    }

    function decimalRound($number)
    {
        $decimals = config("numberformat.decimals");

        return round($number, $decimals);
    }
