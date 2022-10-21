<?php

namespace Drupal\show_location\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Show Time & Location' Block.
 *
 * @Block(
 *   id = "show_location_block",
 *   admin_label = @Translation("Show Time & Location"),
 * )
 */
class ShowLocationBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * To get current time .
   *
   * @var \Drupal\show_location\GetCurrentTime
   */
  protected $getCurrentTime;

  /**
   * Constructs a new timer.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\show_location\GetCurrentTime $getCurrentTime
   *   To get current time .
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, $getCurrentTime) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->GetCurrentTime = $getCurrentTime;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('show_location.get_time')
    );
  }

  /**
   * Builds the Location time block.
   *
   * @return array
   *   A render array.
   */
  public function build() {
    $config = \Drupal::config('location.settings');
    $country = $config->get('country');
    $city = $config->get('city');
    $timezone = $config->get('timezone');
    $get_time = $this->GetCurrentTime->getTime($timezone);

    return [
      '#theme' => 'show_location_block',
      '#data' => ['Country' => $country, 'City' => $city, 'Time' => $get_time],
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

}
