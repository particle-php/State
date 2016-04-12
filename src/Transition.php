<?php
namespace Particle\State;

use League\Event\Emitter;

class Transition
{
    /** @var string */
    private $name;

    /** @var StateCollection */
    private $from;

    /** @var State */
    private $to;

    /**
     * @param string $name
     * @param StateCollection $from
     * @param State $to
     */
    public function __construct($name, StateCollection $from, State $to)
    {
        $this->to = $to;
        $this->from = $from;
        $this->name = $name;
    }

    /**
     * @todo Determine why this must exist.
     *
     * @param State $state
     * @return bool
     */
    public function hasStartState(State $state)
    {
        return $this->from->hasState($state);
    }

    /**
     * @param string $name
     * @param array $from
     * @param State|string $to
     * @return Transition
     */
    public static function withStates($name, array $from, $to)
    {
        if (is_string($to)) {
            $to = State::withName($to);
        }

        return new self($name, StateCollection::withStateNames($from), $to);
    }

    /**
     * @param callable $callable
     * @param Emitter $emitter
     * @return bool
     */
    public function apply(callable $callable, Emitter $emitter)
    {
        call_user_func($callable, $this->to);

        $emitter->emit(
            Event\TransitionApplied::withTransition(
                $this->name,
                $this->from->toArray(),
                (string) $this->to
            )
        );

        return true;
    }

    /**
     * @param TransitionCollection $transitions
     * @return Transition
     * @throws Exception\DuplicateTransition
     */
    public function addToCollection(TransitionCollection $transitions)
    {
        return $transitions->addTransition($this->name, $this);
    }
}
