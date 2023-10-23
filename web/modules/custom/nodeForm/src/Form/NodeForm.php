<?php

namespace Drupal\nodeForm\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
/**
 *
 */
class NodeForm extends FormBase {

  /**
   * { @inheritdoc }
   */
  public function getFormId() {
    return 'create_employee';
  }

  /**
   * { @inheritdoc }
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => ('Name'),
      '#default_value' => '',
      '#required' => TRUE,
      '#attributes' => [
        'placeholder' => 'Enter your name',
      ],
    ];
    $form['about_employee'] = [
      '#type' => 'textarea',
      '#title' => 'Description',
      '#default_value' => '',
      '#required' => TRUE,
      '#attributes' => [
        'placeholder' => 'Write something about the employee',
      ],
    ];
    $form['save'] = [
      '#type' => 'submit',
      '#value' => 'Save Details',
      '#button_type' => 'primary',
    ];
    return $form;
  }

  /**
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config= \Drupal::config('nodeForm.settings');
    $publishnode=$config->get('checked');
    $name = $form_state->getValue('name');
    $about_employee = $form_state->getValue('about_employee');
    $node = Node::create([
      'type'   => 'form',
      'title' => $name,
      'field_name' => $name,
      'body' => $about_employee,
    ]);
    if($publishnode==1){
    $node->setPublished();
    $this->messenger()->addMessage($this->t('Published Node Created Successfully'), 'status', TRUE);
    }else{
    $node->setUnpublished();
    $this->messenger()->addMessage($this->t('Unpublished Node Created'), 'warning', TRUE);
    }
    $node->save();
    // return [
    //   $this->messenger()->addMessage($this->t('Node Created'), 'status', TRUE),
    // ];

  }

}
