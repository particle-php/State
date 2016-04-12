<?php
namespace Particle\State\Event;

use League\Event\Event;
use Particle\State\State;

class TransitionApplied extends Event
{
    /** @var string */
    private $transition;

    /** @var array */
    private $from;

    /** @var string */
    private $to;

    /**
     * @param string $name
     * @param array $from
     * @param string $to
     * @return TransitionApplied
     */
    public static function withTransition($name, $from, $to)
    {
        $event = new self(self::class);

        $event->transition = $name;
        $event->from = $from;
        $event->to = $to;

        return $event;
    }

    /**
     * @param string $transition
     * @return bool
     */
    public function wasTransition($transition)
    {
        return $this->transition === $transition;
    }

    /**
     * @param State $state
     * @return bool
     */
    public function wasFromState(State $state)
    {
        return in_array((string) $state, $this->from);
    }

    /**
     * @param State $state
     * @return bool
     */
    public function wasToState(State $state)
    {
        return $state->equals(State::withName($this->to));
    }

    /**
     * @return string
     */
    public function getTransition()
    {
        return $this->transition;
    }

    /**
     * @return array
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }
}
