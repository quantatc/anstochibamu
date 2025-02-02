<?php

namespace GoDaddy\WordPress\MWC\Common\Events;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Events\Contracts\EventContract;
use GoDaddy\WordPress\MWC\Common\Events\Contracts\SubscriberContract;
use GoDaddy\WordPress\MWC\Common\Events\Exceptions\EventBroadcastFailedException;
use GoDaddy\WordPress\MWC\Common\Events\Exceptions\EventTransformFailedException;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;

/**
 * Event Handler.
 */
class Events
{
    /**
     * Broadcast one or more events.
     *
     * @param EventContract|EventContract[] $events an array of events
     */
    public static function broadcast($events)
    {
        foreach (ArrayHelper::wrap($events) as $event) {
            try {
                static::broadcastEvent($event);
            } catch (EventTransformFailedException $exception) {
                // do nothing - the exception will be automatically reported to Sentry
            } catch (Exception $exception) {
                // no need to throw because new instances of EmailSendFailedException are automatically reported
                new EventBroadcastFailedException($exception->getMessage());
            }
        }
    }

    /**
     * Broadcast an event.
     *
     * @TODO: Add queue support here if the Event has a queueable trait {JO: 2021-03-19}
     *
     * @param EventContract $event
     */
    protected static function broadcastEvent(EventContract $event)
    {
        // may attempt to transform the event before passing down to standard subscribers
        EventTransformers::transform($event);

        foreach (static::getSubscribers($event) as $subscriberClass) {
            static::getSubscriber($subscriberClass)->handle($event);
        }
    }

    /**
     * Gets a subscriber for the given class.
     *
     * @param string $subscriberClass
     * @return SubscriberContract
     */
    protected static function getSubscriber(string $subscriberClass) : SubscriberContract
    {
        return new $subscriberClass();
    }

    /**
     * Gets a list of subscribers.
     *
     * Returns for a given event if provided or all events if none is provided.
     *
     * @param EventContract $event
     * @return string[] array of class names
     * @throws Exception
     */
    public static function getSubscribers(EventContract $event) : array
    {
        $listeners = Configuration::get('events.listeners');

        $subscribers = ArrayHelper::get($listeners, get_class($event), []);

        foreach (class_implements($event) as $interface) {
            $interfaceSubscribers = ArrayHelper::get($listeners, $interface, []);

            $subscribers = ArrayHelper::combine($subscribers, $interfaceSubscribers);
        }

        //dedupe in case any subscribers are set in both class and interface and/or multiple interfaces {WS - 2022-01-24}
        return array_unique($subscribers);
    }

    /**
     * Check if a given event has a given subscriber.
     *
     * @param EventContract $event
     * @param SubscriberContract $subscriber
     * @return bool
     */
    public static function hasSubscriber(EventContract $event, SubscriberContract $subscriber) : bool
    {
        return ArrayHelper::contains(static::getSubscribers($event), get_class($subscriber));
    }
}
