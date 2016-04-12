<?php
namespace Particle\State\Tests;

use Particle\State\State;
use Particle\State\Event;
use Particle\State\StateCollection;
use Particle\State\StateMachine;
use Particle\State\Transition;

use PHPUnit_Framework_TestCase as TestCase;

class EventTest extends TestCase
{
    /** @var StateMachine */
    protected $machine;

    /** @var array */
    protected $log = [];

    public function setUp()
    {
        $states = StateCollection::withStateNames([
            'pending',
            'started',
            'completed',
        ]);

        $this->machine = StateMachine::withStates(State::withName('pending'), $states);
        $this->machine->addTransition(Transition::withStates('start', ['pending'], 'started'));
        $this->machine->addTransition(Transition::withStates('complete', ['started'], 'completed'));
    }

    public function testEventIsTriggered()
    {
        $this->machine->addListener(Event\TransitionApplied::class, function (Event\TransitionApplied $event) {
            if ($event->wasFromState(State::withName('pending'))) {
                $from = implode(', ', $event->getFrom());

                $this->log[] = sprintf(
                    'Transition: "%s", from: "%s", to: "%s"',
                    $event->getTransition(),
                    $from,
                    $event->getTo()
                );
            }

            $this->assertTrue($event->wasTransition('start'));
            $this->assertTrue($event->wasToState(State::withName('started')));
            $this->assertTrue($event->wasFromState(State::withName('pending')));
        });

        $this->machine->transition('start');

        $this->assertEquals(['Transition: "start", from: "pending", to: "started"'], $this->log);
    }
}
