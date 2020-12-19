<?php

namespace undercoder\calendar;

interface DayBuilderInterface
{
    public function build() : AbstractDay;
    public function setDate(string $datetime) : DayBuilderInterface;
    public function getDate() : \Safe\DateTimeImmutable;
    public function setLocale(string $locale = 'spanish') : DayBuilderInterface;
    public function getlocale() : string;
    public function setNames(array $names) : DayBuilderInterface;
    public function getNames() : array;
}
