<?php 
 namespace Drupal\ajax_example\Form;

 use Drupal\Core\Form\FormBase;
 use Drupal\Tests\Core\Form\FormStateInterface;
 use Drupal\Core\Link;


 Class Ajaxexample extends FormBase{
    public function getFormId(){
        return 'deendentdrupaldownform';
    }

    public function buildForm(array $form, \Drupal\Core\Form\FormStateInterface $form_state){
        $state_options = static::getFirstDropdownOptions(); 

        if(empty($form_state->getValue('state_dropdown'))){
            $selected_option = key($state_options);
        }
        else{
            $selected_option = $form_state->getValue('state_dropdown');
        }
        }

 }
?>