<?php
if (! function_exists('getCopyrightYears')) {
    function getCopyrightYears($start) {
        if($start < date('Y')) {
            return $start. " - ".date('Y');
        } else {
            return $start;
        }
    }
}
