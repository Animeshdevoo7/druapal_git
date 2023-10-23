<?php

namespace Drupal\nodeForm\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class Configform extends ConfigFormBase {

    /**
     * Settings Variable.
     */
    Const CONFIGNAME = "nodeForm.settings";

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return "nodeForm_settings";
    }

    /**
     * {@inheritdoc}
     */

    protected function getEditableConfigNames() {
        return [
            static::CONFIGNAME,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config= \Drupal::config('nodeForm.settings');
        $publishnode=$config->get('checked');
        $config = $this->config(static::CONFIGNAME);
        $form['checked'] = [
            '#type' => 'checkbox',
            '#title' => 'Published State',
        ];
        $form['checked']['#default_value'] = $publishnode;
        return Parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $config = $this->config(static::CONFIGNAME);
        $config->set("checked", $form_state->getValue('checked'));
        $config->save();
        $this->messenger()->addMessage($this->t('Configurations saved successfully'), 'status', TRUE);
        
    }

}