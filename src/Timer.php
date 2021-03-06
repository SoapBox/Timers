<?php

namespace SoapBox\Timer;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Timer is a class that exposes the ability to measure the amount of time that
 * has elapsed during code execution.
 */
class Timer implements Arrayable
{
    /**
     * Provides the ability to start a new timer with the provided name.
     *
     * @param string $name
     *
     * @return \SoapBox\Timer\Timer;
     */
    public static function start(string $name): Timer
    {
        Timers::register($timer = new Timer($name));
        return $timer;
    }

    /**
     * The microtime that the timer was stopped.
     *
     * @var float
     */
    private $end;

    /**
     * The name of the timer.
     *
     * @var string
     */
    private $name;

    /**
     * The micrtoime that the timer was started.
     *
     * @var float
     */
    private $start;

    /**
     * Creates a new timer with the provided name.
     *
     * @param string $name
     */
    private function __construct(string $name)
    {
        $this->name = $name;
        $this->start = microtime(true);
    }

    /**
     * Determines if the timer is still running, i.e. measuring time.
     *
     * @return boolean
     */
    public function isRunning(): bool
    {
        return empty($this->end);
    }

    /**
     * Stops the timer.
     *
     * @return void
     */
    public function stop(): void
    {
        if ($this->isRunning()) {
            $this->end = microtime(true);
        }
    }

    /**
     * Determines how long the timer has been running, or the total time it ran
     * in the event that the timer was stopped.
     *
     * @return float
     */
    public function getElapsedTime(): float
    {
        if (empty($this->end)) {
            return microtime(true) - $this->start;
        }
        return $this->end - $this->start;
    }

    /**
     * Returns the name of the timer.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns an array representation of the timer.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'start' => $this->start,
            'end' => $this->end,
            'elapsed' => $this->getElapsedTime()
        ];
    }
}
