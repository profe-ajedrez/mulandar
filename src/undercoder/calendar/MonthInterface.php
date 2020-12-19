<?php

namespace undercoder\calendar;

interface MonthInterface
{
    public const JAN = 0;
    public const FEB = 1;
    public const MAR = 2;
    public const APR = 3;
    public const MAY = 4;
    public const JUN = 5;
    public const JUL = 6;
    public const AUG = 7;
    public const SEP = 8;
    public const OCT = 9;
    public const NOV = 10;
    public const DEC = 11;


    const NAMES = [
        'spanish' => [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
            'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ],
        'english' => [
            'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
            'September', 'October', 'November', 'December'
        ]
    ];

    public function numDays() : int;
    public function name() : string;
    public function numMonth() : int;
    public function iterateDays(callable $callback = null) : void;
    public function getDayNames() : array;
    public function registerEvent(AbstractEvent $event) : array;
    public function isEmpty() : bool;
    public function date() : \Safe\DateTimeImmutable;
}
