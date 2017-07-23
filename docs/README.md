## Table of contents

- [\DateTimeImproved\DateTimeZone](#class-datetimeImproveddatetimezone)
- [\DateTimeImproved\DateTime](#class-datetimeImproveddatetime)

<hr />

### Class: \DateTimeImproved\DateTimeZone

> Improves native DateTimeZone class Class DateTimeZone

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__toString()</strong> : <em>string</em> |
| public static | <strong>from(</strong><em>mixed</em> <strong>$tz</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTimeZone</em><br /><em>create timezone object</em> |
| public | <strong>getUtcOffset()</strong> : <em>int</em><br /><em>get UTC offset the current date</em> |
| public | <strong>jsonSerialize()</strong> : <em>mixed data which can be serialized by <b>json_encode</b>, which is a value of any type other than a resource.</em><br /><em>Specify data which should be serialized to JSON</em> |

*This class extends \DateTimeZone*

*This class implements \JsonSerializable*

<hr />

### Class: \DateTimeImproved\DateTime

> Class DateTime

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string/string/[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime/[\DateTime](http://php.net/manual/en/class.datetime.php)</em> <strong>$time=`'now'`</strong>, <em>string/[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTimeZone</em> <strong>$zone=null</strong>)</strong> : <em>void</em><br /><em>DateTime constructor.</em> |
| public | <strong>__debugInfo()</strong> : <em>array</em> |
| public | <strong>__toString()</strong> : <em>string</em><br /><em>get date in ATOM format</em> |
| public | <strong>addDay(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>addHour(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>addMinute(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>addMonth(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>addSecond(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>addWeek(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>addYear(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>diffDays(</strong><em>[\DateTime](http://php.net/manual/en/class.datetime.php)</em> <strong>$dt</strong>)</strong> : <em>int</em><br /><em>get difference in days</em> |
| public | <strong>format(</strong><em>string</em> <strong>$format</strong>, <em>int/string/[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTimeZone</em> <strong>$zone=null</strong>, <em>string</em> <strong>$locale=null</strong>, <em>bool</em> <strong>$useIsoFormat=false</strong>)</strong> : <em>string</em><br /><em>formats date in specified timezone, optionally localized</em> |
| public | <strong>formatIso(</strong><em>string</em> <strong>$format</strong>, <em>int/string/[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTimeZone</em> <strong>$zone=null</strong>, <em>string</em> <strong>$locale=null</strong>)</strong> : <em>string</em><br /><em>formats date (using iso format modifiers) in specified timezone, optionally localized</em> |
| public | <strong>get(</strong><em>mixed</em> <strong>$format</strong>, <em>int</em> <strong>$zone=null</strong>)</strong> : <em>string</em><br /><em>formats date in specified timezone (=DateTime::get)</em> |
| public | <strong>getAtom()</strong> : <em>string</em><br /><em>formats datetime in ATOM format (2017-07-23T12:03:22+02:00)</em> |
| public | <strong>getCookie()</strong> : <em>string</em><br /><em>formats datetime in COOKIE format (Sunday, 23-Jul-2017 12:06:48 CEST)</em> |
| public | <strong>getDay()</strong> : <em>int</em><br /><em>get 2-digit day</em> |
| public | <strong>getDayName()</strong> : <em>string</em><br /><em>get day name</em> |
| public | <strong>getDayOfWeek()</strong> : <em>int</em><br /><em>get week day no (1-7)</em> |
| public static | <strong>getDaysOfMonth(</strong><em>mixed</em> <strong>$month</strong>, <em>mixed</em> <strong>$year</strong>)</strong> : <em>int</em><br /><em>get maximum days of a given year and month</em> |
| public | <strong>getFormatter()</strong> : <em>[\IntlDateFormatter](http://php.net/manual/en/class.Intldateformatter.php)</em><br /><em>get locale formatter</em> |
| public | <strong>getFull()</strong> : <em>string</em><br /><em>formats datetime in RFC2822 format (e.g. Sun, 23 Jul 2017 12:04:32 +0200)</em> |
| public | <strong>getHour()</strong> : <em>int</em><br /><em>get 2-digit hours</em> |
| public | <strong>getIso()</strong> : <em>string</em><br /><em>formats datetime in ISO8601 format (2017-07-23T12:06:33+0200)</em> |
| public | <strong>getLocale()</strong> : <em>string</em><br /><em>get current locale</em> |
| public | <strong>getMinute()</strong> : <em>int</em><br /><em>get 2-digit minutes</em> |
| public | <strong>getMonth()</strong> : <em>int</em><br /><em>get 2-digit month</em> |
| public | <strong>getMonthName()</strong> : <em>string</em><br /><em>get month name</em> |
| public | <strong>getSecond()</strong> : <em>int</em><br /><em>get 2-digit seconds</em> |
| public | <strong>getTimezone()</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTimeZone</em><br /><em>get timezone object</em> |
| public | <strong>getWeek()</strong> : <em>int</em><br /><em>get week</em> |
| public | <strong>getWeekday()</strong> : <em>int</em><br /><em>get week day no (1-7)</em> |
| public | <strong>getYear()</strong> : <em>int</em><br /><em>get 4-digit year</em> |
| public | <strong>isCurrentMonth()</strong> : <em>bool</em><br /><em>if it is this month</em> |
| public | <strong>isCurrentWeek()</strong> : <em>bool</em><br /><em>if it is this week between Mon-Sun</em> |
| public | <strong>isCurrentYear()</strong> : <em>bool</em><br /><em>if it is this year</em> |
| public | <strong>isDay(</strong><em>int/string</em> <strong>$dayNameOrIndex</strong>, <em>bool</em> <strong>$useLocale=false</strong>)</strong> : <em>bool</em><br /><em>checks the day by name or day index (1=Monday,7=Sunday)</em> |
| public | <strong>isLeapYear()</strong> : <em>bool</em><br /><em>is leap year ?</em> |
| public | <strong>isMonth(</strong><em>int/string</em> <strong>$monthNameOrIndex</strong>, <em>bool</em> <strong>$useLocale=false</strong>)</strong> : <em>bool</em><br /><em>checks the month by name or month index (1=January,12=December)</em> |
| public | <strong>isToday()</strong> : <em>bool</em><br /><em>is active day today ?</em> |
| public | <strong>isTomorrow()</strong> : <em>bool</em><br /><em>is tomorrow</em> |
| public | <strong>isUtc()</strong> : <em>bool</em><br /><em>check if date is in utc timezone</em> |
| public | <strong>isYesterday()</strong> : <em>bool</em><br /><em>is yesterday</em> |
| public | <strong>jsonSerialize()</strong> : <em>mixed data which can be serialized by <b>json_encode</b>, which is a value of any type other than a resource.</em><br /><em>Specify data which should be serialized to JSON</em> |
| public static | <strong>now(</strong><em>string/[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTimeZone/[\DateTimeZone](http://php.net/manual/en/class.datetimezone.php)</em> <strong>$zone=null</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>setBeginningOfDay()</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em><br /><em>set end of month</em> |
| public | <strong>setBeginningOfMonth(</strong><em>bool</em> <strong>$changeTime=true</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em><br /><em>set beginning of month</em> |
| public | <strong>setDay(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\$this</em><br /><em>set day</em> |
| public | <strong>setEndOfDay()</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em><br /><em>set end of month</em> |
| public | <strong>setEndOfMonth(</strong><em>bool</em> <strong>$changeTime=true</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em><br /><em>set end of month</em> |
| public | <strong>setFormatter(</strong><em>string</em> <strong>$locale=null</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\$this</em><br /><em>set locale formatter</em> |
| public | <strong>setHour(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\$this</em><br /><em>set hour</em> |
| public | <strong>setLocale(</strong><em>string</em> <strong>$locale</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\$this</em><br /><em>set locale for the date</em> |
| public | <strong>setMinute(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\$this</em><br /><em>set minute</em> |
| public | <strong>setMonth(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\$this</em> |
| public | <strong>setSecond(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\$this</em><br /><em>set second</em> |
| public | <strong>setTimezone(</strong><em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTimeZone/string</em> <strong>$timezone</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\$this</em> |
| public | <strong>setWeekday(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\$this</em><br /><em>set day of week (1=Monday, 7=Sunday)</em> |
| public | <strong>setYear(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\$this</em><br /><em>set year</em> |
| public | <strong>subDay(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>subHour(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>subMinute(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>subMonth(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>subSecond(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>subWeek(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>subYear(</strong><em>mixed</em> <strong>$i</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public | <strong>toUtc()</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em><br /><em>convert date to utc</em> |
| public static | <strong>tomorrow(</strong><em>string/[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTimeZone/[\DateTimeZone](http://php.net/manual/en/class.datetimezone.php)</em> <strong>$zone=null</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |
| public static | <strong>yesterday(</strong><em>string/[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTimeZone/[\DateTimeZone](http://php.net/manual/en/class.datetimezone.php)</em> <strong>$zone=null</strong>)</strong> : <em>[\DateTime](http://php.net/manual/en/class.datetime.php)Improved\DateTime</em> |

*This class extends \DateTime*

*This class implements \DateTimeInterface, \JsonSerializable*

