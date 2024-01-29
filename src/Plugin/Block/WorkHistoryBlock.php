<?php

namespace Drupal\resume_builder\Plugin\Block;

use Drupal\Core\Block\BlockBase;


/**
 * Provides a 'Work History' block.
 *
 * @Block(
 *   id = "work_history_block",
 *   admin_label = @Translation("Work History")
 * )
 */
class WorkHistoryBlock extends BlockBase {

  public function build() {
    $output = '';
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'work_history']);
    $entity_type = 'node';
    $view_mode = 'full';
    $view_builder = \Drupal::entityTypeManager()->getViewBuilder($entity_type);
    $storage = \Drupal::entityTypeManager()->getStorage($entity_type);
    $nids = array();
    foreach($nodes as $nid => $node_entity) {
      $nids[]=$nid;
    } 
    $build['nodes'] = \Drupal::entityTypeManager()->getViewBuilder('node')->viewMultiple($nodes, 'full');
    return $build;
  }
}