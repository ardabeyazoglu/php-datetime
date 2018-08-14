<?php

chdir(__DIR__);

include_once '../vendor/autoload.php';

use \DateTimeImproved\DateTime;

$date = new DateTime("now", "Europe/Amsterdam");

function printExample($code){
    global /** @noinspection PhpUnusedLocalVariableInspection */
    $date;

    echo $code;

    $length = strlen($code);
    echo str_pad('', 60 - $length, ' ') . "// ";

    if(substr($code, 0, 4) !== 'echo'){
        $code = "echo $code";
    }
    eval('use \DateTimeImproved\DateTime;' . $code . ";");

    echo PHP_EOL;
}

printExample('date_default_timezone_set("UTC");');
printExample('$date = new DateTime("2017-06-03 15:30:15", "UTC");');
printExample('$date = new DateTime("now", "Europe/Amsterdam");');
printExample('$date = new DateTime("+3 hour", "Europe/Amsterdam");');
printExample('$date = new DateTime("-2 day", "Europe/Amsterdam");');
printExample('$date = new DateTime("yesterday", "+01:00");');
printExample('echo $date;');
printExample('echo $date->getTimezone()->getUtcOffset();');
printExample('echo $date->format("F y, l");');
printExample('echo $date->setLocale("es_ES")->format("F y, l");');
printExample('echo $date->setLocale("en_EN");');
printExample('echo $date->formatIso("yyyy-MM-dd");');
printExample('echo $date->getIso();');
printExample('echo $date->getAtom();');
printExample('echo $date->getCookie();');
printExample('echo $date->toUtc()->isUtc() ? "Yes" : "No";');
printExample('echo $date->isMonth("july") ? "Yes" : "No";');
printExample('echo $date->isDay("soboto", true) ? "Yes" : "No";');
printExample('echo $date->isToday() ? "Yes" : "No";');
printExample('echo $date->isCurrentWeek() ? "Yes" : "No";');
printExample('echo $date->isCurrentMonth() ? "Yes" : "No";');
printExample('echo $date->isCurrentYear() ? "Yes" : "No";');
printExample('echo $date->isYesterday() ? "Yes" : "No";');
printExample('echo $date->isTomorrow() ? "Yes" : "No";');
printExample('echo $date->isLeapYear() ? "Yes" : "No";');
printExample('echo $date->addDay(3);');
printExample('echo $date->subDay(2);');
printExample('echo $date->addWeek(-2);');
printExample('echo $date->addMonth(4);');
printExample('echo $date->addYear(1);');
printExample('echo $date->setHour(12);');
printExample('echo $date->setMinute(25);');
printExample('echo $date->getYear();');
printExample('echo $date->getSecond();');
printExample('echo $date->getWeekday();');
printExample('echo $date->getDayName();');
printExample('echo $date->getMonthName();');
printExample('echo $date->diffDays(DateTime::yesterday());');
printExample('echo $date->setBeginningOfDay();');
printExample('echo $date->setEndOfDay();');
printExample('echo $date->setBeginningOfWeek();');
printExample('echo $date->setEndOfWeek();');
printExample('echo $date->setBeginningOfMonth(true);');
printExample('echo $date->setEndOfMonth();');
printExample('echo $date->setBeginningOfQuarter(true);');
printExample('echo $date->setEndOfQuarter();');
printExample('echo json_encode($date);');
printExample('echo DateTime::getDaysOfMonth(2, 2017);');
printExample('echo DateTime::yesterday();');
printExample('echo DateTime::tomorrow();');
printExample('echo DateTime::now("Europe/Istanbul");');
