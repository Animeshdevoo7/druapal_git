<?php

namespace Drupal\form_node\Controller;

use Drupal\Core\Controller\ControllerBase;


class NodeController extends ControllerBase {

  public function content() {
    
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple();
    $date= date('d-m-Y H:i:s', \Drupal::time()->getRequestTime());
    $node_list = '<table>';
    
    foreach ($nodes as $node) {
      $node_list .= '<tr>'.'<td>'."<b>Title:</b>"." ". $node->getTitle()." "."<b>Type::</b>".
      " ".$node->getType(). " "."<b>Date:</b>"." ".$date .'</td>' .'</tr>';
    }
    $node_list .= '</table>';
    return [
      '#markup' => $node_list,
      '#cache'=> ['max-age' => 0],
      
      
    ];
  }
}
