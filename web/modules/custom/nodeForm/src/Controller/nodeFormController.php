<?php

namespace Drupal\nodeForm\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 *
 */
class nodeFormController extends ControllerBase {

  /**
   *
   */
  public function createData() {
    $form = \Drupal::formBuilder()->getForm('Drupal\nodeForm\Form\NodeForm');
    $renderForm = \Drupal::service('renderer')->render($form);
    return [
      '#type' => 'markup',
      '#markup' => $renderForm
    ];
  }

}
