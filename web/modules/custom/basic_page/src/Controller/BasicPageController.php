<?php

namespace Drupal\basic_page\Controller;

use Drupal\Core\Controller\ControllerBase;


class BasicPageController extends ControllerBase
{
    public function basicPage()
    {
        return [
            '#title' => 'Basic Page Information',
            '#markup' => '<h2> hello</h2>'
        ];
    }
    public function information(){
        $data = array(
            'name'=> 'Animesh Dwivedi',
            'email' => 'animesh@example.com'
        );
        return[
            '#title'=> 'Info Page',
            '#theme' => 'information_page',
            '#items' => $data
        ];
    }
}
