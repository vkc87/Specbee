<?php

namespace Drupal\sb_site_location\CacheContext;

use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\Core\Cache\CacheableMetadata;

class SiteLocationCacheContext implements CacheContextInterface {

  /**
   * {@inheritdoc}
   */
  public static function getLabel() {
    return t('Site Location Context');
  }

  /**
  * {@inheritdoc}
  */
  public function getContext() {
    return strtotime(date("d-m-y h:i"));
  }

  /**
  * {@inheritdoc}
  */
  public function getCacheableMetadata() {
    return new CacheableMetadata();
  }

}
