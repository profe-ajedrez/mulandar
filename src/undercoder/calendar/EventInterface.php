<?php

namespace undercoder\calendar;

use undercoder\interfaces\RenderizableInterface;
use undercoder\interfaces\StringableInterface;

interface EventInterface extends StringableInterface, RenderizableInterface
{
    public function name() : string;
    public function notes() : string;
    public function startMoment() : \Safe\DateTimeImmutable;
    public function stopMoment() : \Safe\DateTimeImmutable;
    public function overlaps(AbstractEvent $otherEvent) : bool;
    public function duration() : int;
    public function durationToMinutes() : float;
    public function durationToHours() : float;
    public function durationToDays() : float;
    public function startHour() : int;
    public function startTime() : string;
    public function endHour() :int;
    public function endTime() : string;
    public function startMinute() : int;
    public function startSecond() : int;
    public function endMinute() : int;

    /**
     * endSecond
     *
     * returns the seconds of th stopMoment property of this event
     *
     * @return integer
     */
    public function endSecond() : int;

    /**
     * dayMonth
     *
     * returns the day in month number of the current event,
     * Ex.: in 31 of january, will return 31
     *
     * @return integer
     */
    public function dayMonth() : int;

    /**
     * numMonth
     *
     * Returns the number of the month of this event
     *
     * @return integer
     */
    public function numMonth() : int;
}
