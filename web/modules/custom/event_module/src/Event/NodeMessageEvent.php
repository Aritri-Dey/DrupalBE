<?php 
/**
 * Contains event_module/src/Event/NodeMessageEvent.php
 */

namespace Drupal\event_module\Event;

use Drupal\Component\EventDispatcher\Event;

/**
 * NodeMessage Event class.
 */
class NodeMessageEvent extends Event {

  /**
   * Event name.
   */
  const EVENT_NAME = 'event_module.node_message_event';

  /**
   * Stores the message.
   */
  protected $message;

  /**
   * Constructor.
   */
  public function __construct($message) {
    $this->message = $message;
  }

  /**
   * Function to get the message.
   * 
   *   @return string
   *     Returns the message.
   */
  public function getMessage() {
    return $this->message;
  }

  /**
   * Function to set the message.
   * 
   *   @param string $message
   *     Strores message.
   */
  public function setMessage($message) {
    $this->message = $message;
  }

}
