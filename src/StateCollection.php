<?php
namespace Particle\State;

class StateCollection
{
    /** @var State[] */
    protected $states;

    /**
     * @param array $states
     */
    private function __construct(array $states)
    {
        array_map([$this, 'addState'], $states);
    }

    /**
     * @param array $states
     * @return StateCollection
     */
    public static function withStates(array $states)
    {
        return new self($states);
    }

    /**
     * @param array $states
     * @return StateCollection
     */
    public static function withStateNames(array $states)
    {
        $toState = function ($state) {
            return State::withName($state);
        };

        return new self(array_map($toState, $states));
    }

    /**
     * @param State $check
     * @return bool
     */
    public function hasState(State $check)
    {
        foreach ($this->states as $state) {
            if ($check->equals($state)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param State $state
     */
    protected function addState(State $state)
    {
        $this->states[] = $state;
    }

    public function toArray()
    {
        return array_map('strval', $this->states);
    }
}
