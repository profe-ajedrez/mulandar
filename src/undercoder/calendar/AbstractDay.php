<?php

namespace undercoder\calendar;

abstract class AbstractDay
{
    public const SECOND_PER_DAY = 0;
    public const NAMES = [
        'spanish' =>  [
            'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado', 'Dómingo'
        ],
        'english' => [
            'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
        ]
    ];


    private array $names;
    private string $locale;
    private array $events;
    private \Safe\DateTimeImmutable $date;

    public function __construct(DayBuilderInterface $dayBuilder)
    {
        $this->date = $dayBuilder->getDate(); //new \Safe\DateTimeImmutable($date);
        $this->names = $dayBuilder->getNames();
        $this->locale = $dayBuilder->getLocale();
        $this->events = [];
    }

    public function registerEvent(AbstractEvent $event) : array
    {
        $this->events[$event->name] = $event;
        return $this->validate($event);
    }

    public function validate(AbstractEvent $event = null) : array
    {
        $overlaps = false;
        $ellapsed = 0;
        $allEventsBelongsToDay = true;
        $this->iterate(
            function (int $i, AbstractEvent &$e, array &$events, AbstractDay &$day) use ($event, $overlaps, $ellapsed, $allEventsBelongsToDay) {
                $overlaps = $overlaps || $event->overlaps($e) || $event == null;
                $ellapsed += $ellapsed + $e->duration();
                $allEventsBelongsToDay = $allEventsBelongsToDay &&
                    $this->date->format('Y-m-d') === $e->startMoment->format('Y-m-d');
            }
        );

        if ($ellapsed > self::SECOND_PER_DAY) {
            return [
                'success' => false,
                'log' => 'Ellapsed durations is greater tha duration of a day'
            ];
        }

        if ($overlaps) {
            return [
                'success' => false,
                'log' => 'events overlaps'
            ];
        }

        if (!$allEventsBelongsToDay) {
            return [
                'success' => false,
                'log' => 'Some events doesnt belongs to this day'
            ];
        }

        return [
            'success' => true,
            'log' => ''
        ];
    }


    public function iterate(callable $callback = null)
    {
        $default = function () {
            /** default */
        };
        $callback = (is_null($callback) ? $default : $callback);
        $index = 0;
        foreach ($this->events as $event) {
            $callback($index, $event, $this->events, $this);
            $index++;
        }
    }

    public function names()
    {
        return $this->names[ $this->locale ];
    }

    public function name()
    {
        return $this->names[ $this->locale ][ intval($this->date->format('w')) ];
    }

    public function weekDayNumber()
    {
        return intval($this->date->format('w'));
    }

    public function dayMonth()
    {
        return intval($this->date->format('j'));
    }

    public function iso8601Day()
    {
        return intval($this->date->format('N'));
    }

    public function yearDay()
    {
        return intval($this->date->format('z'));
    }

    public function date()
    {
        return $this->date;
    }

    public function isEmpty()
    {
        return empty($this->events);
    }


    abstract public function __toString() : string;
}
