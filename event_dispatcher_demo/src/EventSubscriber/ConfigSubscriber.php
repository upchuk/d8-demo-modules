<?php

/**
 * @file
 * Contains Drupal\event_dispatcher_demo\EventSubscriber\ConfigSubscriber.
 */

namespace Drupal\event_dispatcher_demo\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConfigSubscriber implements EventSubscriberInterface {

  static function getSubscribedEvents() {
    $events['demo_form.save'][] = array('onConfigSave', 0);
    return $events;
  }

  public function onConfigSave($event) {

    // Get the config object from the event.
    $config = $event->getConfig();

    // Create a new value to be stored in the config and set it.
    $name_website = $config->get('my_name') . " / " . $config->get('my_website');
    $config->set('my_name_website', $name_website);

  }

}
