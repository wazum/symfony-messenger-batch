# How to handle messages in batches with Symfony Messenger.

This is a complete working example project for my in-depth [article](https://wolfgang-klinger.medium.com/how-to-handle-messages-in-batches-with-symfony-messenger-c91b5aa1c8b1) about handling messages in batches with [Symfony Messenger](https://symfony.com/doc/current/messenger.html).

## Requirements

You need a Redis server running (I used a docker container) and configure it as

```
MESSENGER_TRANSPORT_DSN=redis://<your redis server>:<your port>/messages
```

in the `.env` file

## Test run

To see the batch processing in action you have to run the following commands:

- `./bin/console app:import`

which imports some cat facts as events into the redis cache and then

- `./bin/console messenger:consume async`

which consumes the async transport and processes the messages.

## Result

The result should be something like

```
Processed new batch of cat facts
------------------------------------------------------------
1. Cats eat grass to aid their digestion and to help them get rid of any fur in their stomachs.
2. Purring does not always indicate that a cat is happy. Cats will also purr loudly when they are distressed or in pain.
3. A cat's cerebral cortex contains about twice as many neurons as that of dogs. Cats have 300 million neurons, whereas dogs have about 160 million. See, cats rule, dogs drool!
4. Every year, nearly four million cats are eaten in Asia.
5. Cats do not think that they are little people. They think that we are big cats. This influences their behavior in many ways.
6. Blue-eyed, pure white cats are frequently deaf.
7. It has been scientifically proven that stroking a cat can lower one's blood pressure.
8. Neutering a male cat will, in almost all cases, stop him from spraying (territorial marking), fighting with other males (at least over females), as well as lengthen his life and improve its quality.
9. A group of cats is called a “clowder.”
10. Today there are about 100 distinct breeds of the domestic cat.
11. The first cat in space was a French cat named Felicette (a.k.a. “Astrocat”) In 1963, France blasted the cat into outer space. Electrodes implanted in her brains sent neurological signals back to Earth. She survived the trip.
12. Siamese kittens are born white because of the heat inside the mother's uterus before birth. This heat keeps the kittens' hair from darkening on the points.


Processed new batch of cat facts
------------------------------------------------------------
1. The average lifespan of an outdoor-only (feral and non-feral) is about 3 years; an indoor-only cat can live 16 years and longer. Some cats have been documented to have a longevity of 34 years.
2. The smallest pedigreed cat is a Singapura, which can weigh just 4 lbs (1.8 kg), or about five large cans of cat food. The largest pedigreed cats are Maine Coon cats, which can weigh 25 lbs (11.3 kg), or nearly twice as much as an average cat weighs.
3. Unlike humans, cats are usually lefties. Studies indicate that their left paw is typically their dominant paw.
```

on the console.

Happy batch processing!
