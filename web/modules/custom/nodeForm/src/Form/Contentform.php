<?php

namespace Drupal\nodeForm\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
/**
 *
 */
class Contentform extends FormBase {

  /**
   * { @inheritdoc }
   */
  public function getFormId() {
    return 'create_node';
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
    $publishnode=$config->get('node1');
    $publishtype1=$config->get('node2');
    $name = $form_state->getValue('name');
    $about_employee = $form_state->getValue('about_employee');
    if($publishnode == 1 && $publishtype1 == 1){
        $node1 = Node::create([
            'type'   => 'nodeone',
            'title' => $name,
            'field_name' => $name,
            'body' => $about_employee,
          ]);
        $node2 = Node::create([
            'type'   => 'nodetwo',
            'title' => $name,
            'field_name' => $name,
            'body' => $about_employee,
          ]);  
          $node1->save();
          $node2->save();
          $this->messenger()->addMessage($this->t('Both Nodes created successfully!'), 'status', TRUE);
    }
    elseif($publishnode == 1){
    $node1 = Node::create([
      'type'   => 'nodeone',
      'title' => $name,
      'field_name' => $name,
      'body' => $about_employee,
    ]);
    $node1->save();
    $this->messenger()->addMessage($this->t('Nodeone Created'), 'status', TRUE);
}
elseif($publishtype1 == 1){
    $node2 = Node::create([
        'type'   => 'nodetwo',
        'title' => $name,
        'field_name' => $name,
        'body' => $about_employee,
      ]);
      $node2->save();
      $this->messenger()->addMessage($this->t('Nodetwo Created'), 'status', TRUE);
}
elseif ($publishnode==0||$publishtype1=0){
    $this->messenger()->addMessage($this->t('Node not Created'), 'error', TRUE);
}



    // return [
    //   $this->messenger()->addMessage($this->t('Node Created'), 'status', TRUE),
  }

}