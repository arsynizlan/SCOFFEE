<?php

use Carbon\Carbon;


function tanggal($date)
{
    // return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    return Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();
}
