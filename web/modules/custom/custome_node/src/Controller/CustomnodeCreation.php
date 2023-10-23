<?php
namespace Drupal\custom_node\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

class CustomnodeCreation extends ControllerBase{
    public function content(){
            $node = Node::create(['type' => 'article']);
            $node-> set('title','test node');
            $node-> set('uid',1);
            $node-> status= 1;
            $node->save();
        return[
            $this->messenger()->addMessage($this->t('Node Created Successfully'), 'status',TRUE)
        ]; 
    }



}





?>