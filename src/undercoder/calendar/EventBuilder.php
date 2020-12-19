<?php

namespace undercoder\calendar;

use stdClass;
use WeakReference;

class EventBuilder
{
    private array $params = [];

    public function name(string $name) : EventBuilder
    {
        $this->params['name'] = $name;
        return $this;
    }

    public function notes(string $notes) : EventBuilder
    {
        $this->params['notes'] = $notes;
        return $this;
    }

    public function startMoment(string $startMoment) : EventBuilder
    {
        $startMoment = new \Safe\DateTimeImmutable($startMoment);
        $this->params['startMoment'] = $startMoment;
        return $this;
    }

    public function stopMoment(string $stopMoment) : EventBuilder
    {
        $stopMoment = new \Safe\DateTimeImmutable($stopMoment);
        $this->params['stopMoment'] = $stopMoment;
        return $this;
    }

    public function onStartCallback(callable $onStartCallback = null) : EventBuilder
    {
        $this->params['onStartCallback'] = $onStartCallback ?? function () {
        };
        return $this;
    }

    public function onEndCallback(callable $onEndCallback = null) : EventBuilder
    {
        $this->params['onEndCallback'] = $onEndCallback ?? function () {
        };
        return $this;
    }

    public function externalReference(WeakReference $ref = null) : EventBuilder
    {
        $dummyClass = new stdClass();
        $this->params['externalRef'] = $ref ?? WeakReference::create($dummyClass);
        return $this;
    }

    public function build() : AbstractEvent
    {
        return new AbstractEvent($this);
    }


    public function getName()
    {
        return $this->params['name'];
    }
    public function getNotes()
    {
        return $this->params['notes'];
    }
    public function getStartMoment()
    {
        return $this->params['startMoment'];
    }
    public function getStopMoment()
    {
        return $this->params['stopMoment'];
    }
    public function getOnStartCallback()
    {
        return $this->params['onStartCallback'];
    }
    public function getOnEndCallback()
    {
        return $this->params['onEndCallback'];
    }
    public function getExternalRef()
    {
        return $this->params['externalRef'];
    }
}
