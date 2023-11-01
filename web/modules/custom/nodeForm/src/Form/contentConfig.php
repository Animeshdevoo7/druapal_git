<?php

namespace Drupal\nodeForm\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class contentConfig extends ConfigFormBase {

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
        $publishnode=$config->get('node1');
        $publishtype2=$config->get('node2');
        $config = $this->config(static::CONFIGNAME);
        $form['node1'] = [
            '#type' => 'checkbox',
            '#title' => 'Node1',
        ];
        $form['node2'] = [
            '#type' => 'checkbox',
            '#title' => 'Node2',
        ];
        $form['node1']['#default_value'] = $publishnode;
        $form['node2']['#default_value'] = $publishtype2;
        return Parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $config = $this->config(static::CONFIGNAME);
        $config->set("node1", $form_state->getValue('node1'));
        $config->set("node2", $form_state->getValue('node2'));

        $config->save();
        $this->messenger()->addMessage($this->t('Configurations saved successfully'), 'status', TRUE);
        
    }

}