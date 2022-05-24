<?php

namespace Drupal\sb_site_location\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\sb_site_location\TimeZoneManager;
use Drupal\Core\Cache\Cache;

/**
 * Provides a block for displaying country, city and time.
 *
 * @Block(
 *   id = "sb_time_zone_block",
 *   admin_label = @Translation("SB Time Zone"),
 * )
 */
class TimeZoneBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * TimeZoneManager service.
   *
   * @var \Drupal\sb_site_location\TimeZoneManager
   */
  protected $timeZoneServices;


  /**
   * The construct.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param array $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   * @param \Drupal\sb_site_location\TimeZoneManager $timezone_manager
   *   The timezone services.
   */
  public function __construct(array $configuration,
    $plugin_id,
    array $plugin_definition,
    DateFormatterInterface $date_formatter,
    ConfigFactoryInterface $config_factory,
    TimeZoneManager $timezone_manager) {

    parent::__construct($configuration, $plugin_id, $plugin_definition, $config_factory);
    $this->dateFormatter = $date_formatter;
    $this->config = $config_factory->get('sb_site_location.settings');
    $this->timezoneServices = $timezone_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration, $plugin_id, $plugin_definition,
      $container->get('date.formatter'),
      $container->get('config.factory'),
      $container->get('sb_site_location.timezone_manager'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $data = [];
    $city = $this->config->get('city');
    $country = $this->config->get('country');
    $timezone = $this->config->get('timezone');
    $time = $this->timezoneServices->getTime($timezone);

    $data = [
      'time' => $time,
      'country' => $country,
      'city' =>  $city,
    ];

    return [
      "#theme" => 'sb_site_location_time_block',
      "#data" => $data,
     ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    $time = $this->timezoneServices->getTime($timezone);
    return Cache::mergeTags(parent::getCacheTags(), [$time]);

}
