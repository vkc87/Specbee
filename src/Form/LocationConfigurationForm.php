<?php

namespace Drupal\sb_site_location\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configuration for Location and Timezone.
 *
 * @internal
 */
class LocationConfigurationForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sb_site_location_settings';
  }

  /**
   * Implements ConfigFormBase::getEditableConfigNames.
   */
  protected function getEditableConfigNames() {
    return ['sb_site_location.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $sb_config = $this->config('sb_site_location.settings');

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => !empty($sb_config->get('country')) ? $sb_config->get('country') : '',
      '#description' => $this->t('Enter Country.'),
      '#required' => TRUE,
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => !empty($sb_config->get('city')) ? $sb_config->get('city') : '',
      '#description' => $this->t('Enter City.'),
      '#required' => TRUE,
    ];

    $timezone_options = [
      'America/Chicago' => $this->t('America/Chicago'),
      'America/New_york' => $this->t('America/New york'),
      'Asia/Tokyo' => $this->t('Asia/Tokyo'),
      'Asia/Dubai'  => $this->t('Asia/Dubai'),
      'Asia/Kolkata' => $this->t('Asia/Kolkata'),
      'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
      'Europe/Oslo' => $this->t('Europe/Oslo'),
      'Europe/London' => $this->t('Europe/London'),
    ];

    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Time Zone'),
      '#options' => $timezone_options,
      '#default_value' => !empty($sb_config->get('timezone')) ? $sb_config->get('timezone') : '',
      '#description' => $this->t('Select the timezone that matches the Country and City'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Implements FormBuilder::submitForm().
   *
   * Serialize the user's settings and save it to the Drupal's config Table.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->configFactory->getEditable('sb_site_location.settings')
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
