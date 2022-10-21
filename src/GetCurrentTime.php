<?php

namespace Drupal\show_location;

use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Class GetCurrentTime implementation.
 *
 * @package Drupal\show_location\Services
 */
class GetCurrentTime {

  /**
   * Implementation of getTime().
   */
  public function getTime($time_zone = NULL) {
    if (isset($time_zone)) {
      $date = new DrupalDateTime();
      $date->setTimezone(new \DateTimeZone($time_zone));
      $dateTime = $date->format('dS M Y - g:i A');
    }
    else {
      $dateTime = t('Time zone not configured.');
    }
    return $dateTime;
  }

}
