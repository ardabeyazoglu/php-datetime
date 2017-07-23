# About
Improved DateTime functionality for php by extending native DateTime and DateTimeZone classes. You can use shorthand methods for various operations. Also, different locales are supported, thanks to `Intl` extension.
Feel free to create issues and contribute.

# Installation

    composer require ardabeyazoglu/datetime

# Usage

```php
<?php

use \DateTimeImproved\DateTime;

date_default_timezone_set("UTC");                           // 

$date = new DateTime("2017-06-03 15:30:15", "UTC");         // Sat, 03 Jun 2017 15:30:15 +0000
$date = new DateTime("now", "Europe/Amsterdam");            // Sun, 23 Jul 2017 22:22:33 +0200
$date = new DateTime("+3 hour", "Europe/Amsterdam");        // Mon, 24 Jul 2017 01:22:33 +0200
$date = new DateTime("-2 day", "Europe/Amsterdam");         // Fri, 21 Jul 2017 22:22:33 +0200
$date = new DateTime("yesterday", "+01:00");                // Sat, 22 Jul 2017 21:22:33 +0100
echo $date;                                                 // Sat, 22 Jul 2017 21:22:33 +0100
echo $date->getTimezone()->getUtcOffset();                  // 3600
echo $date->format("F y, l");                               // July 17, Saturday
echo $date->setLocale("es_ES")->format("F y, l");           // julio 17, sábado
echo $date->setLocale("en_EN");                             // Sat, 22 Jul 2017 21:22:33 +0100
echo $date->formatIso("yyyy-MM-dd");                        // 2017-07-22
echo $date->getIso();                                       // 2017-07-22T21:22:33+0100
echo $date->getAtom();                                      // 2017-07-22T21:22:33+01:00
echo $date->getCookie();                                    // Saturday, 22-Jul-2017 21:22:33 GMT+1
echo $date->toUtc()->isUtc() ? "Yes" : "No";                // Yes
echo $date->isMonth("july") ? "Yes" : "No";                 // Yes
echo $date->isDay("soboto", true) ? "Yes" : "No";           // No
echo $date->isToday() ? "Yes" : "No";                       // No
echo $date->isCurrentWeek() ? "Yes" : "No";                 // Yes
echo $date->isCurrentMonth() ? "Yes" : "No";                // Yes
echo $date->isCurrentYear() ? "Yes" : "No";                 // Yes
echo $date->isYesterday() ? "Yes" : "No";                   // Yes
echo $date->isTomorrow() ? "Yes" : "No";                    // No
echo $date->isLeapYear() ? "Yes" : "No";                    // No
echo $date->addDay(3);                                      // Tue, 25 Jul 2017 20:22:33 +0000
echo $date->subDay(2);                                      // Sun, 23 Jul 2017 20:22:33 +0000
echo $date->addWeek(-2);                                    // Sun, 09 Jul 2017 20:22:33 +0000
echo $date->addMonth(4);                                    // Thu, 09 Nov 2017 20:22:33 +0000
echo $date->addYear(1);                                     // Fri, 09 Nov 2018 20:22:33 +0000
echo $date->setHour(12);                                    // Fri, 09 Nov 2018 12:22:33 +0000
echo $date->setMinute(25);                                  // Fri, 09 Nov 2018 12:25:33 +0000
echo $date->getYear();                                      // 2018
echo $date->getSecond();                                    // 33
echo $date->getWeekday();                                   // 5
echo $date->getDayName();                                   // Friday
echo $date->getMonthName();                                 // November
echo $date->diffDays(DateTime::yesterday());                // -474
echo $date->setBeginningOfDay();                            // Fri, 09 Nov 2018 00:00:00 +0000
echo $date->setEndOfDay();                                  // Fri, 09 Nov 2018 23:59:59 +0000
echo $date->setBeginningOfMonth(true);                      // Thu, 01 Nov 2018 00:00:00 +0000
echo $date->setEndOfMonth();                                // Fri, 30 Nov 2018 23:59:59 +0000
echo json_encode($date);                                    // {"datetime":"2018-11-30T23:59:59+00:00","timezone":{"name":"UTC","location":{"country_code":"??","latitude":0,"longitude":0,"comments":""}},"locale":"en_EN"}
echo DateTime::getDaysOfMonth(2, 2017);                     // 28
echo DateTime::yesterday();                                 // Sat, 22 Jul 2017 20:22:33 +0000
echo DateTime::tomorrow();                                  // Mon, 24 Jul 2017 20:22:33 +0000
echo DateTime::now("Europe/Istanbul");                      // Sun, 23 Jul 2017 23:22:33 +0300

```

* Check out the [docs](https://github.com/ardabeyazoglu/php-datetime/tree/master/docs) for all methods.

# ToDo

- Unit tests