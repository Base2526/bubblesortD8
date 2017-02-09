<?php

/**
 * @file
 * Bubblesort form builder.
 */

namespace Drupal\bubblesort\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Builds the bubblesort form.
 */
class BubblesortForm extends FormBase {

  /**
   * Returns form id.
   *
   * {@inheritDoc}
   */
  public function getFormId() {
    return 'bubblesortform';
  }

  /**
   * Returns form elements.
   *
   * {@inheritDoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    global $base_url;
    $form['#theme'] = 'bubblesortform';
    $form['#attached']['library'][] = 'bubblesort/bubblesort-form';
    $form['#attached']['drupalSettings']['baseUrl'] = $base_url;

    $form['numbers_total'] = array(
      '#type' => 'number',
      '#title' => $this->t('Total number of bars:'),
      '#required' => TRUE,
      '#min' => 1,
      '#max' => 35,
    );
    $form['integer_min'] = array(
      '#type' => 'number',
      '#title' => $this->t('First number:'),
      '#required' => TRUE,
      '#min' => 1,
      '#max' => 99,
    );
    $form['integer_max'] = array(
      '#type' => 'number',
      '#title' => $this->t('Second number:'),
      '#required' => TRUE,
      '#min' => 1,
      '#max' => 99,
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Shuffle'),
    );
    $form['step_button'] = array(
      '#type' => 'button',
      '#value' => $this->t('Step'),
      '#attributes' => array('onclick' => 'return (false);'),
    );
    $form['play_button'] = array(
      '#type' => 'button',
      '#value' => $this->t('Play'),
      '#attributes' => array('onclick' => 'return (false);'),
    );

    return $form;
  }

  /**
   * Validates form.
   *
   * {@inheritDoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    if ($values['integer_max'] <= $values['integer_min']) {
      $form_state->setErrorByName('integer_max', t('Second number must be greater than the first number.'));
    }
  }

  /**
   * Submits form.
   *
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message($this->t('@total bars between @min and @max', array(
      '@total' => $form_state->getValue('numbers_total'),
      '@min' => $form_state->getValue('integer_min'),
      '@max' => $form_state->getValue('integer_max'),
      )));
    $form_state->setRebuild();
  }
}
