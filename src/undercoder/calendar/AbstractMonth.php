<?php

namespace undercoder\calendar;

abstract class AbstractMonth implements MonthInterface
{
    private \Safe\DateTimeImmutable $date;
    private string $locale;
    private array $localeNames;
    private array $days;

    public function __construct(
        int $month,
        int $year,
        DayBuilderInterface $dayBuilder,
        string $locale = 'spanish',
        array $localeNames = self::NAMES
    ) {
        if ($month > MonthInterface::DEC  || $month < MonthInterface::JAN) {
            throw new \RuntimeException('inavlid month number in ' . __CLASS__);
        }
        $m = $month + 1;

        $this->date = new \Safe\DateTimeImmutable("{$year}-{$m}-01T15:52:01+0000");
        $this->locale = $locale;
        $this->localeNames = $localeNames;
        $s = $this->numDays();
        for ($i = 1; $i <= $s; $i++) {
            $d = str_pad($i, 2, '0', STR_PAD_LEFT);
            $date = (new \Safe\DateTimeImmutable("{$year}-{$month}-{$d}"))->format('Y-m-d');
            $day = $dayBuilder->setDate($date)->build();
            $this->days[$i] = $day;
        }
    }

    public function numDays() : int
    {
        return intval($this->date->format('t'));
    }

    public function name() : string
    {
        return $this->localeNames[$this->locale][ $this->numMonth() -1 ];
    }

    public function numMonth() : int
    {
        return intval($this->date->format('n'));
    }


    public function iterateDays(callable $callback = null) : void
    {
        if ($callback === null) {
            $callback = function () {
            };
        }
        $i = 0;
        foreach ($this->days as $d) {
            $callback($i, $d, $this->days, $this);
            $i++;
        }
    }

    public function getDayNames() : array
    {
        return $this->days[1]->names();
    }

    public function registerEvent(AbstractEvent $event) : array
    {
        $d = $event->dayMonth();
        $m = $event->numMonth();
        if ($m === $this->numMonth() && $d <= $this->numMonth()) {
            return $this->days[ $d ]->registerEvent($event);
        }
        return [
            'success' => false,
            'msg' => 'event day out of month'
        ];
    }

    public function isEmpty() : bool
    {
        return empty($this->days);
    }


    public function date() : \Safe\DateTimeImmutable
    {
        return $this->date;
    }

    abstract public function __toString() : string;
    abstract public function onRender() : void;
}
