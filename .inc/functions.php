<?php

//
//
//      Copyright (C) 2010 Paul Halliday <paul.halliday@gmail.com>
//
//      This program is free software: you can redistribute it and/or modify
//      it under the terms of the GNU General Public License as published by
//      the Free Software Foundation, either version 3 of the License, or
//      (at your option) any later version.
//
//      This program is distributed in the hope that it will be useful,
//      but WITHOUT ANY WARRANTY; without even the implied warranty of
//      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//      GNU General Public License for more details.
//
//      You should have received a copy of the GNU General Public License
//      along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
//


function math($stamp) {
    list($a,$b) = explode(":",$stamp);
    $c = $a * 60 + $b;
    return $c;
}

function retAv($x) {
    $y = array_sum($x);
    if ($y > 0) {
        $answer = $y / count($x);
        return $answer;
    }
    return 0;
}

function ret95($x) {
    sort($x);
    $answer = $x[round((95/100) * count($x) - .5)];
    return $answer;
}

function retND($x) {
    $x_std = stats_standard_deviation($x);
    $x_av = retAv($x);
    $answer = (array_sum($x) - $x_av) / $x_std;
    return $answer;
}

function retSD($x) {
    $answer = stats_standard_deviation($x);
    return $answer;
}

function dbC() {
    if (file_exists('.inc/config.php')) {
        global $dbHost,$dbName,$dbUser,$dbPass;
        $link = mysql_connect($dbHost,$dbUser,$dbPass);

        if (!$link) {
            die('Connection failed: ' . mysql_error());
        }

        $db = mysql_select_db($dbName,$link);

        if (!$db) {
            die('Database selection failed: ' . mysql_error());
        }

    } else {
        echo "<center>
              <b>Configuration file not found</b><br>
              Edit 'config.php.sample' to taste and then rename it to 'config.php'
              </center>";
        die();
    }

}

// Query date and time
function fixTime($sDate, $sTime, $eDate, $eTime) {
    global $offset;
    $start = strtotime("$sDate $sTime");
    $end = strtotime("$eDate $eTime");
    $startDate = date("Y-m-d H:i:s", $start);
    $endDate = date("Y-m-d H:i:s", $end);
    $when = "timestamp BETWEEN CONVERT_TZ('$startDate','$offset','+00:00') AND CONVERT_TZ('$endDate','$offset','+00:00')";

    return $when;
}

function hextostr($x) {
  $s='';
  foreach(explode("\n",trim(chunk_split($x,2))) as $h) $s.=chr(hexdec($h));
  return($s);
}

function strtohex($x) {
  $s='';
  foreach(str_split($x) as $c) $s.=sprintf("%02X",ord($c));
  return($s);
} 

?>
