<?php

namespace Drupal\employee\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class EmployeeForm extends FormBase
{

    /**   
     *  { @inheritdoc }
     */
    public function getFormId()
    {
        return 'create_employee';
    }
    /**    
     * { @inheritdoc } 
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $genderOptions = array(
            'Male' => 'Male',
            'Female' => 'Female'
        );
        $form['name'] = array(
            '#type' => 'textfield',
            '#title' => ('Name'),
            '#default_value' => '',
            '#required' => true,
            '#attributes' => array(
                'placeholder' => 'Enter your name'
            )
        );
        $form['gender'] = array(
            '#type' => 'select',
            '#title' => ('Gender'),
            '#options' => $genderOptions,
            '#required' => true
        );
        $form['about_employee'] = array(
            '#type' => 'textarea',
            '#title' => 'About Employee',
            '#default_value' => '',
            '#required' => true,
            '#attributes' => array(
                'placeholder' => 'Write something about the employee'
            )
        );
        $form['save'] = array(
            '#type' => 'submit',
            '#value' => 'Save Employee',
            '#button_type' => 'primary'
        );
        return $form;
    }
    /**
     * {@inheritDoc}
     */

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $name = $form_state->getValue('name');
        if (trim($name) == '') {
            $form_state->setErrorByName('name', $this->t('Name field is required'));
        } else if ($form_state->getValue('gender') == '0') {
            $form_state->setErrorByName('gender', $this->t('Please select gender'));
        } else if ($form_state->getValue('about_employee') == '') {
            $form_state->setErrorByName('about_employee', $this->t('Employee about section is empty. Please add some text'));
        }
    }

    /**
     * {@inheritDoc}
     */

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $postData = [
            'name' => $form_state->getValue('name'),
            'gender' => $form_state->getValue('gender'),
            'about_employee' => $form_state->getValue('about_employee'),
            'create_date'=> date('Y-m-d H:i:s', \Drupal::time()->getRequestTime())

        ];


        /** remove unwanted keys  */
        unset($postData['save'], $postData['form_build_id'], $postData['form_token'], $postData['form_id']);


        $query = \Drupal::database();
        $query->insert('employees')->fields($postData)->execute();

        $this->messenger()->addMessage($this->t('Form Submitted Successfully'), 'status',TRUE);
    }
}