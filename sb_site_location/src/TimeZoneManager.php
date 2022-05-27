<?php

namespace Drupal\sb_site_location;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Component\Datetime;

/*
 * Class TimeZoneManager for providing time based on timezone.
 */
class TimeZoneManager {

  /**
   * Contains the configuration object factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config;

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * The construct.
   *
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   */
  public function __construct(DateFormatterInterface $date_formatter) {
    $this->dateFormatter = $date_formatter;
  }


  /**
   * Function to fetch time based on the provided time zone.
   */
  public function getTime($timezone = NULL) {
    if (!empty($timezone)) {
      $date = strtotime(date('m/d/Y h:i:s a', time()));
      $formatted_time = $this->dateFormatter->format($date,'custom', 'jS M Y - h:i A ', $timezone);

      return $formatted_time;
    }

  }

}
