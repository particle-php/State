# Particle\State

*Particle\State* is a very small and simple library, implementing a finite state machine. You can use it in your
application whenever you need to account for transitions between multiple states (and that's probably more often
than you would imagine!).

### Why?

With [winzou/statemachine][winzou] and [yohang/finite][finite] already in Packagist, why would we go for another
package implementing the very same concept?

Well, first of all, Particle\State is very small in comparison, doing next to nothing. That means everything it
*does* do is easy to follow, without having to wade through lots of code. Also, by doing only one thing, it's
rather easy to learn how to use this library.

On top of that, we wanted to have a library that is not obtrusive: you can implement *Particle\State* without
having to model your objects in a certain way. Indeed, *Particle\State* does not have any interface you need to
implement.

Nevertheless, check them out. Maybe they'll serve you better.

## Small usage example

```php
$initialState = State::withName('pending');

$machine = StateMachine::withStates($initialState, StateCollection::withStates([
    State::withName('pending'),
    State::withName('started'),
    State::withName('accepted'),
    State::withName('rejected'),
    State::withName('completed'),
    State::withName('failed'),
]));

$machine->addTransition(Transition::withStates('start', ['pending'], 'started'));
$machine->addTransition(Transition::withStates('accept', ['started'], 'accepted'));

$machine->addListener(function (Event\TransitionApplied $event) {
    if ($event->wasFromState(State::withName('pending')) {
        echo "The state was pending. Not anymore though :)";
    }
});

var_dump($machine->canApplyTransition('accept')); // bool(false), because not in 'started' state;
var_dump($machine->canApplyTransition('start')); // bool(true);
var_dump($machine->transition('start')); // bool(true);
var_dump($machine->canApplyTransition('accept')); // bool(true);
var_dump($machine->canApplyTransition('start')); // bool(false);
```

## Functional features

* Validate if a transition of state is possible;
* Transition the state to a next state;
* Hook event listeners to state changes as transition callbacks.

## Non functional features

* Easy to write (IDE auto-completion for easy development)
* Easy to read (improves peer review)

[winzou]: https://github.com/winzou/state-machine
[finite]: https://github.com/yohang/Finite
