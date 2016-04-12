<?php
namespace Particle\State;

class State
{
    /** @var string */
    private $state;

    /**
     * @param string $state
     */
    private function __construct($state)
    {
        $this->state = $state;
    }

    /**
     * @param string $state
     * @return State
     */
    public static function withName($state)
    {
        return new self($state);
    }

    /**
     * @param State $state
     * @return bool
     */
    public function equals(State $state)
    {
        return $state->state === $this->state;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->state;
    }
}
