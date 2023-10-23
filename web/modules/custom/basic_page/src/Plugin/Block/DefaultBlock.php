<?php
namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'DefaultBlock' block.
 * @Block(
 *  id = "default_block",
 *  admin_label = @Translation("Hello World"),
 *  )
 */



class DefautBlock extends BlockBase{

/**
 * { @inheritdoc}
 */

 public function build(){
    $build=[];
    $build['#theme']='default_block';
    $build['default_block']['#markup'] = 'Implement Defaultblock';

    return $build;
 }
}









?>
