<?php
namespace Drupal\newmod\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure newmod settings for this site.
 */
class SettingsForm extends ConfigFormBase {
    /** @var string Config settings */
  const SETTINGS = 'newmod.settings';

  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'newmod_admin_settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'newmod.settings',
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['count'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Count'),
      '#default_value' => $config->get('count'),
    ];  

    $form['time'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Time'),
      '#default_value' => $config->get('time'),
    ];  

    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
      // Retrieve the configuration
       $this->configFactory->getEditable(static::SETTINGS)
      // Set the submitted configuration setting
      ->set('count', $form_state->getValue('count'))
      // You can set multiple configurations at once by making
      // multiple calls to set()
      ->set('time', $form_state->getValue('time'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}