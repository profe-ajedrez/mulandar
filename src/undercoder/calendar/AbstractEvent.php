<?php

namespace undercoder\calendar;

use WeakReference;

abstract class AbstractEvent implements EventInterface
{
    private string $name;
    private string $notes;
    private \Safe\DateTimeImmutable $startMoment;
    private \Safe\DateTimeImmutable $stopMoment;
    private \Closure $onStartCallback;
    private \Closure $onEndCallback;
    private WeakReference $externalReference;

    public function __construct(
        EventBuilder $eventBuilder
    ) {
        $this->name = $eventBuilder->getName();
        $this->notes = $eventBuilder->getNotes();
        $this->startHour = $eventBuilder->getStartMoment();
        $this->startMinute = $eventBuilder->getStopMoment();
        $this->onStartCallback = $eventBuilder->getOnStartCallback();
        $this->onEndCallback = $eventBuilder->getOnEndCallback();
        $this->externalReference = $eventBuilder->getExternalRef();
    }

    public function name() : string
    {
        return $this->name;
    }

    public function notes() : string
    {
        return $this->notes;
    }

    public function startMoment() : \Safe\DateTimeImmutable
    {
        return $this->startMoment;
    }

    public function stopMoment() : \Safe\DateTimeImmutable
    {
        return $this->stopMoment;
    }

    public function overlaps(AbstractEvent $otherEvent) : bool
    {
        return max($this->startMoment, $otherEvent->startMoment) < max($this->stopMoment, $otherEvent->stopMoment);
    }

    public function duration() : int
    {
        $interval = date_diff($this->stopMoment, $this->startMoment);
        return date_create('@0')->add($interval)->getTimestamp();
    }

    public function durationToMinutes() : float
    {
        return $this->duration() / 60;
    }

    public function durationToHours() : float
    {
        return $this->duration() / 3600;
    }

    public function durationToDays() : float
    {
        return $this->duration() / (3600 * 24);
    }

    public function startHour() : int
    {
        return intval($this->startMoment->format('H'));
    }

    public function startTime() : string
    {
        return $this->startMoment->format('H:i:s');
    }


    public function endHour() : int
    {
        return intval($this->stopMoment->format('H'));
    }

    public function endTime() : string
    {
        return $this->stopMoment->format('H:i:s');
    }


    public function startMinute() : int
    {
        return intval($this->startHour()) * 60 + intval($this->startMoment->format('i'));
    }

    public function startSecond() : int
    {
        return $this->startMinute() * 60 + intval($this->startMoment->format('s'));
    }

    public function endMinute() : int
    {
        return intval($this->endHour()) * 60 + intval($this->stoptMoment->format('i'));
    }

    public function endSecond() : int
    {
        return $this->endMinute() * 60 + intval($this->stopMoment->format('s'));
    }

    public function dayMonth() : int
    {
        return intval($this->startMoment->format('j'));
    }

    public function numMonth() : int
    {
        return intval($this->date->format('n'));
    }


    abstract public function __toString() : string;
    abstract public function onRender() : void;
}
