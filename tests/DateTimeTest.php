<?php

use \DateTimeImproved\DateTime;

/**
 * @covers DateTime
 * Class DateTimeTest
 */
final class DateTimeTest extends PHPUnit_Framework_TestCase {

    public function testNow(){
        $this->assertTrue(time() === DateTime::now()->getTimestamp());
    }

    public function testToday(){
        $this->assertTrue((new DateTime())->isToday());
    }

    public function testYesterday(){
        $this->assertTrue(date("Ymd", strtotime("-1 day")) === DateTime::yesterday()->get("Ymd"));
    }

    public function testTomorrow(){
        $this->assertTrue(date("Ymd", strtotime("+1 day")) === DateTime::tomorrow()->get("Ymd"));
    }

    public function testIfDaysOfJanuary(){
        $this->assertTrue(DateTime::getDaysOfMonth(1, 2017) === 31);
    }

    public function testDaysOfFebruary(){
        $this->assertTrue(DateTime::getDaysOfMonth(2, 2017) === 28);
    }

    public function testDaysOfFebruaryInLeapYear(){
        $this->assertTrue(DateTime::getDaysOfMonth(2, 2016) === 29);
    }

    public function testLeapYear(){
        $d = new DateTime();
        $d->setYear(2016);
        $this->assertTrue($d->isLeapYear());
    }

    public function testAddSecond(){
        $d = new DateTime();
        $t1 = $d->getTimestamp();
        $d->addSecond(55);
        $t2 = $d->getTimestamp();
        $this->assertTrue($t2 - $t1 === 55);
    }

    public function testAddMinute(){
        $d = new DateTime();
        $t1 = $d->getTimestamp();
        $d->addMinute(55);
        $t2 = $d->getTimestamp();
        $this->assertTrue($t2 - $t1 === 55*60);
    }

    public function testAddHour(){
        $d = new DateTime();
        $t1 = $d->getTimestamp();
        $d->addHour(23);
        $t2 = $d->getTimestamp();
        $this->assertTrue($t2 - $t1 === 23*3600);
    }

    public function testAddDay(){
        $d = new DateTime();
        $t1 = $d->getTimestamp();
        $d->addDay(55);
        $t2 = $d->getTimestamp();
        $this->assertTrue($t2 - $t1 === 55*24*3600);
    }

    public function testAddWeek(){
        $d = new DateTime();
        $t1 = $d->getTimestamp();
        $d->addWeek(18);
        $t2 = $d->getTimestamp();
        $this->assertTrue($t2 - $t1 === 18*7*24*3600);
    }

    /**
     * data provider for month tests
     * @return array
     */
    public function providerTestMonth(){
        return array(
            [1], [2], [3], [4], [5], [6], [7], [8], [9], [10],
            [11], [12], [13], [14], [15], [16], [17], [18], [19],
            [20], [21], [22], [23], [24], [25]
        );
    }

    /**
     * @dataProvider providerTestMonth
     * @param $i
     */
    public function testAddMonth($i){
        $d = new DateTime();
        $t1 = date("Ymd", strtotime("$i month"));
        $d->addMonth($i);
        $t2 = $d->get("Ymd");
        $this->assertEquals($t1, $t2,"$t1 == $t2");
    }

    /**
     * @dataProvider providerTestMonth
     * @param $i
     */
    public function testSubMonth($i){
        $d = new DateTime();
        $t1 = date("Ymd", strtotime("-$i month"));
        $d->subMonth($i);
        $t2 = $d->get("Ymd");
        $this->assertEquals($t1, $t2,"$t1 == $t2");
    }

    /**
     * @dataProvider providerTestMonth
     * @param $i
     */
    public function testAddYear($i){
        $d = new DateTime();
        $t1 = date("Ym", strtotime("$i year"));
        $d->addYear($i);
        $t2 = $d->get("Ym");
        $this->assertEquals($t1, $t2,"$t1 == $t2");
    }

    /**
     * data provider for weekdays
     * @return array
     */
    public function providerTestWeekday(){
        return array(
            [1], [2], [3], [4], [5], [6], [7]
        );
    }

    /**
     * @dataProvider providerTestWeekday
     * @param $i
     */
    public function testSetWeekday($i){
        $d = new DateTime();
        $d->setWeekday($i);
        $this->assertTrue($d->getWeekday() === $i);
    }

    public function testSetDay(){
        $d = new DateTime();
        $d->setDay(30);
        $this->assertTrue($d->getDay() === 30);
    }

    /**
     * @dataProvider providerTestMonth
     * @param $i
     */
    public function testSetMonth($i){
        if($i <= 12){
            $d = new DateTime();
            $d->setMonth($i);
            $this->assertTrue($d->getMonth() === $i);
        }
    }

    public function testSetYear(){
        $d = new DateTime();
        $t1 = $d->get("md");
        $d->setYear(2020);
        $t2 = $d->get("Ymd");
        $this->assertEquals("2020$t1", $t2);
    }

    public function testDiffDays(){
        $start = new DateTime();
        $end = DateTime::tomorrow();
        $this->assertEquals($start->diffDays($end), 1);
    }

    public function testBeginningOfDay(){
        $d = new DateTime();
        $t1 = $d->get("Ymd") . "00:00:00";
        $d->setBeginningOfDay();
        $t2 = $d->get("YmdH:i:s");
        $this->assertEquals($t1, $t2);
    }

    public function testBeginningOfMonth(){
        $d = new DateTime();
        $t1 = $d->get("Ym") . "01";
        $d->setBeginningOfMonth();
        $t2 = $d->get("Ymd");
        $this->assertEquals($t1, $t2);
    }

    public function testEndOfDay(){
        $d = new DateTime();
        $t1 = $d->get("Ymd") . "23:59:59";
        $d->setEndOfDay();
        $t2 = $d->get("YmdH:i:s");
        $this->assertEquals($t1, $t2);
    }

    public function testEndOfMonth(){
        $d = new DateTime();
        $t1 = $d->get("Ym") . DateTime::getDaysOfMonth($d->getMonth(), $d->getYear());
        $d->setEndOfMonth();
        $t2 = $d->get("Ymd");
        $this->assertEquals($t1, $t2);
    }

    /**
     * data provider for day names
     * @return array
     */
    public function providerDayNames(){
        return [
            [1, "monday"], [2, "tuesday"], [3, "wednesday"], [4, "thursday"], [5, "friday"], [6, "saturday"], [7, "sunday"]
        ];
    }

    /**
     * @dataProvider providerDayNames
     * @param $i
     * @param $name
     */
    public function testIsDay($i, $name){
        $d = new DateTime();
        $d->setWeekday($i);
        $this->assertTrue($d->isDay($name));
    }

    /**
     * data provider for month names
     * @return array
     */
    public function providerMonthNames(){
        return [
            [1, "january"], [2, "february"], [3, "march"], [4, "april"], [5, "may"], [6, "june"],
            [7, "july"], [8, "august"], [9, "september"], [10, "october"], [11, "november"], [12, "december"]
        ];
    }

    /**
     * @dataProvider providerMonthNames
     * @param $i
     * @param $name
     */
    public function testIsMonth($i, $name){
        $d = new DateTime();
        $d->setMonth($i);
        $this->assertTrue($d->isMonth($name));
    }

    public function testTimezone(){
        $d1 = new DateTime("2020-12-01 15:30:00","UTC");
        $d2 = new DateTime("2020-12-01 15:30:00","EET");

        $offset = $d2->getTimezone()->getUtcOffset();

        $this->assertEquals($d1->getTimestamp() - $d2->getTimestamp(), $offset);
    }

    public function testFormatIso(){
        $d = new DateTime();
        $this->assertEquals($d->format("Y-m-d H:i:s"), $d->formatIso("yyyy-MM-dd HH:mm:ss"));
    }
}