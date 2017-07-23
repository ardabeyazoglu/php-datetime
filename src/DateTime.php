<?

namespace DateTimeImproved;

/**
 * Class DateTime
 * @package DateTime
 * @author Arda Beyazoglu
 */
class DateTime extends \DateTime implements \JsonSerializable {

    /**
     * cache for number of days in specific months
     * @var array
     */
    private static $_mcache = array();

    /**
     * @var string
     */
    private $_locale = null;

    /**
     * @var \IntlDateFormatter
     */
    private $_formatter = null;

    /**
     * DateTime constructor.
     * @param string|DateTime|\DateTime $time
     * @param string|DateTimeZone $zone timezone
     * @throws \Exception
     */
    public function __construct($time = 'now', $zone = null){
        if(is_null($time)) $time = 'now';

        if(is_string($zone)){
            $timezone = new DateTimeZone($zone);
        }
        else if($zone instanceof DateTimeZone){
            $timezone = $zone;
        }
        else{
            $timezone = null;
        }

        // create datetime object
        $timestamp = null;
        $locale = null;

        if($time instanceof DateTime){
            $timezone = $time->getTimezone();
            $locale = $time->getLocale();

            // dont include timezone offset here, because it changes timezone type of datetime object
            $time = $time->format("Y-m-d H:i:s");
        }
        else if($time instanceof \DateTime){
            $timezone = $time->getTimezone();
            $time = $time->format("Y-m-d H:i:s");
        }
        else if(is_numeric($time)){
            $timestamp = $time;
            $time = "now";
        }
        else if(is_string($time)){
            // human readable format
            $time = strtolower($time);
            if(in_array($time, ['now', 'yesterday', 'tomorrow'])){
                // 'now' is default
                if($time === 'yesterday'){
                    $time = self::now($timezone)->subDay(1);
                }
                else if($time === 'tomorrow'){
                    $time = self::now($timezone)->addDay(1);
                }
            }
            else if(preg_match("/([+-]?[0-9]+)[\s]+(second|minute|hour|day|week|month|year)+/i", $time, $matches) > 0){
                $i = intval($matches[1]);
                $m = $matches[2];
                $time = DateTime::now($timezone)->modify("$i $m");
            }
        }

        try {
            parent::__construct($time, $timezone);
        }
        catch(\Exception $ex){
            if(is_string($time) && stristr($ex->getMessage(), "Failed to parse") !== false){
                $time = str_replace(["/", "."], "-", $time);
                parent::__construct($time, $timezone);
            }
            else{
                throw $ex;
            }
        }

        if(!is_null($timestamp)){
            $this->setTimestamp((int)$timestamp);
        }
        if(!is_null($locale)){
            $this->setLocale($locale);
        }

        // to fix timezone type problem
        if(!is_null($timezone)){
            try {
                $this->setTimezone($timezone);
            }
            catch(\Exception $ex){}
        }
    }

    /**
     * @param string|DateTimeZone|\DateTimeZone $zone
     * @return DateTime
     */
    public static function now($zone = null){
        return new self("now", $zone);
    }

    /**
     * @param string|DateTimeZone|\DateTimeZone $zone
     * @return DateTime
     */
    public static function yesterday($zone = null){
        return new self("yesterday", $zone);
    }

    /**
     * @param string|DateTimeZone|\DateTimeZone $zone
     * @return DateTime
     */
    public static function tomorrow($zone = null){
        return new self("tomorrow", $zone);
    }

    /**
     * formats date in specified timezone, optionally localized
     * @param string $format
     * @param int|string|DateTimeZone $zone
     * @param string $locale
     * @param bool $useIsoFormat
     * @return string
     */
    public function format($format, $zone = null, $locale = null, $useIsoFormat = false){
        $timezone = $this->getTimezone();

        if(!is_null($zone)){
            if(is_string($zone)){
                $this->setTimezone(new DateTimeZone($zone));
            }
            else if($zone instanceof DateTimeZone){
                $this->setTimezone($zone);
            }
        }

        if(is_null($locale)) $locale = $this->_locale;

        if($useIsoFormat || (!is_null($locale) && preg_match("/[DlFMr]+/", $format, $matches) > 0)){
            // try to localize if and only if locale is specified and format contains localizable modifiers (or iso format modifiers are used)

            $format = !$useIsoFormat ? $this->_convertPhpToIsoFormat($format) : $format;
            $str = $this->getFormatter()->formatObject($this, $format, $locale);
        }
        else{
            $str = parent::format($format);
        }

        if(!is_null($zone)){
            $this->setTimezone($timezone);
        }

        return $str;
    }

    /**
     * formats date (using iso format modifiers) in specified timezone, optionally localized
     * @param string $format
     * @param int|string|DateTimeZone $zone
     * @param string $locale
     * @return string
     */
    public function formatIso($format, $zone = null, $locale = null){
        return $this->format($format, $zone, $locale, true);
    }

    /**
     * converts php format to iso, copied by zend framework
     * @see https://framework.zend.com/manual/1.12/en/zend.date.constants.html#zend.date.constants.selfdefinedformats
     * @param $format
     * @return string
     */
    private function _convertPhpToIsoFormat($format){
        if($format === null){
            return null;
        }

        $convert = array(
            'd' => 'dd'  , 'D' => 'EE'  , 'j' => 'd'   , 'l' => 'EEEE', 'N' => 'eee' , 'S' => 'SS'  ,
            'w' => 'e'   , 'z' => 'D'   , 'W' => 'ww'  , 'F' => 'MMMM', 'm' => 'MM'  , 'M' => 'MMM' ,
            'n' => 'M'   , 't' => 'ddd' , 'L' => 'l'   , 'o' => 'YYYY', 'Y' => 'yyyy', 'y' => 'yy'  ,
            'a' => 'a'   , 'A' => 'a'   , 'B' => 'B'   , 'g' => 'h'   , 'G' => 'H'   , 'h' => 'hh'  ,
            'H' => 'HH'  , 'i' => 'mm'  , 's' => 'ss'  , 'e' => 'zzzz', 'I' => 'I'   , 'O' => 'Z'   ,
            'P' => 'ZZZZ', 'T' => 'z'   , 'Z' => 'X'   , 'c' => 'yyyy-MM-ddTHH:mm:sZZZZ',
            'r' => 'r'   , 'U' => 'U'
        );

        $values = str_split($format);
        foreach($values as $key => $value){
            if(isset($convert[$value]) === true) {
                $values[$key] = $convert[$value];

                if($key > 0 && $values[$key - 1] == '\\'){
                    $values[$key - 1] = "";
                    $values[$key] = $value;
                }
            }
        }

        return implode("", $values);
    }

    /**
     * formats date in specified timezone (=DateTime::get)
     * @see DateTime::format()
     * @param $format
     * @param int $zone
     * @return string
     */
    public function get($format, $zone = null){
        return $this->format($format, $zone);
    }

    /**
     * formats datetime in ISO8601 format (2017-07-23T12:06:33+0200)
     * @return string
     */
    public function getIso(){
        return $this->format(DateTime::ISO8601);
    }

    /**
     * formats datetime in ATOM format (2017-07-23T12:03:22+02:00)
     * @return string
     */
    public function getAtom(){
        return $this->format(DateTime::ATOM);
    }

    /**
     * formats datetime in COOKIE format (Sunday, 23-Jul-2017 12:06:48 CEST)
     * @return string
     */
    public function getCookie(){
        return $this->format(DateTime::COOKIE);
    }

    /**
     * formats datetime in RFC2822 format (e.g. Sun, 23 Jul 2017 12:04:32 +0200)
     * @return string
     */
    public function getFull(){
        return $this->format(DateTime::RFC2822);
    }

    /**
     * set locale for the date
     * @param string $locale
     * @return $this
     */
    public function setLocale($locale){
        $this->_locale = $locale;
        return $this;
    }

    /**
     * get current locale
     * @return string
     */
    public function getLocale(){
        return $this->_locale;
    }

    /**
     * set locale formatter
     * @param string $locale
     * @return $this
     */
    public function setFormatter($locale = null){
        if(is_null($locale)){
            if(is_null($this->_locale)){
                $this->setLocale(\Locale::getDefault());
            }
            $locale = $this->_locale;
        }

        $this->_formatter = new \IntlDateFormatter($locale, \IntlDateFormatter::NONE, \IntlDateFormatter::NONE, $this->getTimezone(), \IntlDateFormatter::GREGORIAN);

        return $this;
    }

    /**
     * get locale formatter
     * @return \IntlDateFormatter
     */
    public function getFormatter(){
        if(is_null($this->_formatter)){
            $this->setFormatter();
        }

        return $this->_formatter;
    }

    /**
     * @param DateTimeZone|string $timezone
     * @return $this
     */
    public function setTimezone($timezone){
        try {
            if(is_string($timezone)){
                $timezone = new DateTimeZone($timezone);
            }

            parent::setTimezone($timezone);
        }
        catch(\Exception $ex){

        }

        return $this;
    }

    /**
     * get timezone object
     * @return DateTimeZone
     */
    public function getTimezone(){
        $tz = parent::getTimezone();
        if(!($tz instanceof DateTimeZone)){
            $tz = DateTimeZone::from($tz);
        }

        return $tz;
    }

    /**
     * check if date is in utc timezone
     * @return bool
     */
    public function isUtc(){
        return intval($this->getTimezone()->getUtcOffset()) === 0;
    }

    /**
     * convert date to utc
     * @return DateTime
     */
    public function toUtc(){
        return $this->setTimezone(new DateTimeZone("UTC"));
    }

    /**
     * get maximum days of a given year and month
     * @param $month
     * @param $year
     * @return int
     */
    public static function getDaysOfMonth($month, $year){
        if(!array_key_exists($year . $month, self::$_mcache)){
            self::$_mcache[$year . $month] = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        }

        return self::$_mcache[$year . $month];
    }

    /**
     * @param $i
     * @return DateTime
     */
    public function addSecond($i){
        $this->modify("+$i second");
        return $this;
    }

    /**
     * @param $i
     * @return DateTime
     */
    public function subSecond($i){
        $this->modify("-$i second");
        return $this;
    }

    /**
     * @param $i
     * @return DateTime
     */
    public function addMinute($i){
        $this->modify("+$i minute");
        return $this;
    }

    /**
     * @param $i
     * @return DateTime
     */
    public function subMinute($i){
        $this->modify("-$i minute");
        return $this;
    }

    /**
     * @param $i
     * @return DateTime
     */
    public function addHour($i){
        $this->modify("+$i hour");
        return $this;
    }

    /**
     * @param $i
     * @return DateTime
     */
    public function subHour($i){
        $this->modify("-$i hour");
        return $this;
    }

    /**
     * @param $i
     * @return DateTime
     */
    public function addDay($i){
        $this->modify("+$i day");
        return $this;
    }

    /**
     * @param $i
     * @return DateTime
     */
    public function subDay($i){
        $this->modify("-$i day");
        return $this;
    }

    /**
     * @param $i
     * @return DateTime
     */
    public function addWeek($i){
        $this->modify("+$i week");
        return $this;
    }

    /**
     * @param $i
     * @return DateTime
     */
    public function subWeek($i){
        $this->modify("-$i week");
        return $this;
    }

    /**
     * @param $i
     * @return DateTime
     */
    public function addMonth($i){
        $day = $this->getDay();
        $month = $this->getMonth();
        $year = $this->getYear();

        if($i + $month > 0){
            $newYear = floor(($month + $i) / 12) + $year;
            $newMonth = ($month + $i) % 12;
        }
        else{
            $newYear = $year - floor(abs($month + $i) / 12) - 1;
            $newMonth = 12 - (abs($month + $i) % 12);
        }

        $maxDays = $this->getDaysOfMonth($newMonth, $newYear);
        $newDay = $day > $maxDays ? $maxDays : $day;

        $this->setDate($newYear, $newMonth, $newDay);

        return $this;
    }

    /**
     * @param $i
     * @return DateTime
     */
    public function subMonth($i){
        return $this->addMonth(-1 * $i);
    }

    /**
     * @param $i
     * @return DateTime
     */
    public function addYear($i){
        return $this->addMonth(12 * $i);
    }

    /**
     * @param $i
     * @return DateTime
     */
    public function subYear($i){
        return $this->addMonth(-12 * $i);
    }

    /**
     * set hour
     * @param $i
     * @return $this
     */
    public function setHour($i){
        return $this->setTime($i, $this->format("i"), $this->format("s"));
    }

    /**
     * set minute
     * @param $i
     * @return $this
     */
    public function setMinute($i){
        return $this->setTime($this->format("H"), $i, $this->format("s"));
    }

    /**
     * set second
     * @param $i
     * @return $this
     */
    public function setSecond($i){
        return $this->setTime($this->format("H"), $this->format("i"), $i);
    }

    /**
     * set day
     * @param $i
     * @return $this
     */
    public function setDay($i){
        return $this->setDate($this->format("Y"), $this->format("m"), $i);
    }

    /**
     * set day of week (1=Monday, 7=Sunday)
     * @param $i
     * @return $this
     * @throws \Exception
     */
    public function setWeekday($i){
        if($i > 7 || $i < 1){
            throw new \Exception("Weekday can only be from 1 to 7");
        }

        $weekday = $this->getWeekday();
        $diff = $i - $weekday;
        if($diff !== 0){
            $this->addDay($diff);
        }

        return $this;
    }

    /**
     * @param $i
     * @return $this
     */
    public function setMonth($i){
        return $this->setDate($this->getYear(), $i, $this->getDay());
    }

    /**
     * set year
     * @param $i
     * @return $this
     */
    public function setYear($i){
        return $this->setDate($i, $this->getMonth(), $this->getDay());
    }

    /**
     * get 2-digit hours
     * @return int
     */
    public function getHour(){
        return (int)$this->format("H");
    }

    /**
     * get 2-digit minutes
     * @return int
     */
    public function getMinute(){
        return (int)$this->format("i");
    }

    /**
     * get 2-digit seconds
     * @return int
     */
    public function getSecond(){
        return (int)$this->format("s");
    }

    /**
     * get 2-digit day
     * @return int
     */
    public function getDay(){
        return (int)$this->format("d");
    }

    /**
     * get day name
     * @return string
     */
    public function getDayName(){
        return $this->format("l");
    }

    /**
     * get month name
     * @return string
     */
    public function getMonthName(){
        return $this->format("F");
    }

    /**
     * get week day no (1-7)
     * @return int
     */
    public function getWeekday(){
        return (int)$this->format("N");
    }

    /**
     * get week day no (1-7)
     * @return int
     */
    public function getDayOfWeek(){
        return $this->getWeekday();
    }

    /**
     * get week
     * @return int
     */
    public function getWeek(){
        return (int)$this->format("W");
    }

    /**
     * get 2-digit month
     * @return int
     */
    public function getMonth(){
        return (int)$this->format("m");
    }

    /**
     * get 4-digit year
     * @return int
     */
    public function getYear(){
        return (int)$this->format("Y");
    }

    /**
     * get difference in days
     * @param \DateTime $dt
     * @return int
     */
    public function diffDays(\DateTime $dt){
        $interval = $this->diff($dt);
        return (int)$interval->format("%R%a");
    }

    /**
     * set end of month
     * @param bool $changeTime
     * @return DateTime
     */
    public function setEndOfMonth($changeTime = true){
        $this->setDay($this->getDaysOfMonth($this->getMonth(), $this->getYear()));
        if($changeTime) $this->setTime(23, 59, 59);
        return $this;
    }

    /**
     * set beginning of month
     * @param bool $changeTime
     * @return DateTime
     */
    public function setBeginningOfMonth($changeTime = true){
        $this->setDay(1);
        if($changeTime) $this->setTime(0, 0, 0);
        return $this;
    }

    /**
     * set end of month
     * @return DateTime
     */
    public function setEndOfDay(){
        $this->setTime(23, 59, 59);
        return $this;
    }

    /**
     * set end of month
     * @return DateTime
     */
    public function setBeginningOfDay(){
        $this->setTime(0, 0, 0);
        return $this;
    }

    /**
     * is active day today ?
     * @return bool
     */
    public function isToday(){
        return $this->format("Ymd") == (new self("now", $this->getTimezone()))->format("Ymd");
    }

    /**
     * if it is this week between Mon-Sun
     * @return bool
     */
    public function isCurrentWeek(){
        $dtWeek = $this->getYear() . $this->getWeek();

        $today = new self("now", $this->getTimezone());
        $currentWeek = $today->getYear() . $today->getWeek();

        return $dtWeek === $currentWeek;
    }

    /**
     * if it is this month
     * @return bool
     */
    public function isCurrentMonth(){
        $dtMonth = $this->getYear() . $this->getMonth();

        $today = new self("now", $this->getTimezone());
        $currentMonth = $today->getYear() . $today->getMonth();

        return $dtMonth === $currentMonth;
    }

    /**
     * if it is this year
     * @return bool
     */
    public function isCurrentYear(){
        return $this->getYear() === DateTime::now($this->getTimezone())->getYear();
    }

    /**
     * is leap year ?
     * @return bool
     */
    public function isLeapYear(){
        return $this->getDaysOfMonth(2, $this->getYear()) == 29;
    }

    /**
     * checks the day by name or day index (1=Monday,7=Sunday)
     * @param int|string $dayNameOrIndex
     * @param bool $useLocale true to check localized day names
     * @return bool
     */
    public function isDay($dayNameOrIndex, $useLocale = false){
        if(is_numeric($dayNameOrIndex)){
            return $this->getDay() === intval($dayNameOrIndex);
        }
        else{
            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            $names = [$days[$this->getDayOfWeek() - 1]];
            if($useLocale) $names[] = mb_strtolower($this->format("l"), "UTF-8");

            return in_array(mb_strtolower((string)$dayNameOrIndex, "UTF-8"), $names, true);
        }
    }

    /**
     * checks the month by name or month index (1=January,12=December)
     * @param int|string $monthNameOrIndex
     * @param bool $useLocale true to check localized month names
     * @return bool
     */
    public function isMonth($monthNameOrIndex, $useLocale = false){
        if(is_numeric($monthNameOrIndex)){
            return $this->getMonth() === intval($monthNameOrIndex);
        }
        else{
            $months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
            $names = [$months[$this->getMonth() - 1]];
            if($useLocale) $names[] = mb_strtolower($this->format("F"), "UTF-8");

            return in_array(mb_strtolower((string)$monthNameOrIndex, "UTF-8"), $names, true);
        }
    }

    /**
     * is yesterday
     * @return bool
     */
    public function isYesterday(){
        return intval($this->format("Ymd")) === intval(self::yesterday()->format("Ymd"));
    }

    /**
     * is tomorrow
     * @return bool
     */
    public function isTomorrow(){
        return intval($this->format("Ymd")) === intval(self::tomorrow()->format("Ymd"));
    }

    /**
     * get date in ATOM format
     * @return string
     */
    public function __toString(){
        return $this->format(self::RFC2822);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize(){
        return [
            "datetime" => $this->format(self::ATOM),
            "timezone" => $this->getTimezone(),
            "locale" => $this->getLocale()
        ];
    }

    /**
     * @return array
     */
    public function __debugInfo(){
        return [
            "datetime" => $this->format(self::ATOM),
            "timezone" => $this->getTimezone(),
            "locale" => $this->getLocale()
        ];
    }
}

?>