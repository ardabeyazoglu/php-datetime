<?php

namespace DateTimeImproved;

/**
 * Improves native DateTimeZone class
 * Class DateTimeZone
 * @package DateTimeImproved
 * @author Arda Beyazoglu
 */
class DateTimeZone extends \DateTimeZone implements \JsonSerializable {

    private static $_cache = [];

    /**
     * create timezone object
     * @param $tz
     * @return DateTimeZone
     */
    public static function from($tz){
        if($tz instanceof self){
            return $tz;
        }
        else if($tz instanceof \DateTimeZone){
            $tz = $tz->getName();
        }
        else{
            $tz = (string)$tz;
        }

        if(isset(self::$_cache[$tz])){
            return self::$_cache[$tz];
        }
        else{
            $timezone = new self($tz);
            self::$_cache[$tz] = $timezone;
            return $timezone;
        }
    }

    /**
     * get UTC offset the current date
     * @return int
     */
    public function getUtcOffset(){
        $datetime = new DateTime('now', 'UTC');
        return parent::getOffset($datetime);
    }

    /**
     * @return string
     */
    public function __toString(){
        return $this->getName();
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
            "name" => $this->getName(),
            "location" => $this->getLocation()
        ];
    }
}