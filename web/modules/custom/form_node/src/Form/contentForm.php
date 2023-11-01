<?php

namespace Drupal\form_node\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
class ContentForm extends FormBase{

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
      
        $form['title'] = array(
            '#type' => 'textfield',
            '#title' => ('Title'),
            '#default_value' => '',
            '#required' => true,
            '#attributes' => array(
                'placeholder' => 'Enter title here'
            )
        );

        $form['Movie'] = array(
            '#type' => 'number',
            '#title' => 'Movie',
            '#default_value' => '',
            '#attributes' => array(
                'placeholder' => 'Enter upto 10 only'
            )
            
        );

        $form['Music'] = array(
            '#type' => 'number',
            '#title' => 'Music',
            '#default_value' => '',
            '#attributes' => array(
                'placeholder' => 'Enter upto 10 only'
            )
            
        );

        $form['Short'] = array(
            '#type' => 'number',
            '#title' => ('Short'),
            '#default_value' => '',
            '#attributes' => array(
                'placeholder' => 'Enter upto 10 only'
            )
            
        );

        $form['save'] = array(
            '#type' => 'submit',
            '#value' => 'Create Nodes',
            '#button_type' => 'primary'
        );
    
        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
            $title = $form_state->getValue('title');
            $movie = $form_state->getValue('Movie');
            $music = $form_state->getValue('Music');
            $short = $form_state->getValue('Short');
            $movienum=intval($movie);
            $musicnum=intval($music);
            $shortnum=intval($short);
            // var_dump($num);
            // dd($num);
         for($i=0;$i<$movienum;$i++){
            $node1 = Node::create([
             'type'  => 'movie',
             'title' => $title,
             ]); 
            $node1->save();
         }
         for($j=0;$j<$musicnum;$j++){
            $node2 = Node::create([
             'type'   => 'music',
             'title' => $title,
             ]); 
            $node2->save();
         }
         for($k=0;$k<$shortnum;$k++){
            $node3 = Node::create([
             'type'   => 'short',
             'title' => $title,
             ]); 
            $node3->save();           
              
  $this->messenger()->addMessage($this->t('Nodes Created Successfully'), 'status',TRUE);
}
}
}






















?>