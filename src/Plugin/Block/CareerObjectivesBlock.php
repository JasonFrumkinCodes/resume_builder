<?php

namespace Drupal\resume_builder\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Career Objectives' block.
 *
 * @Block(
 *   id = "career_objectives_block",
 *   admin_label = @Translation("Career Objectives")
 * )
 */
class CareerObjectivesBlock extends BlockBase {

  public function build() {
    $output = '';
    $config = \Drupal::config('resume_builder.settings'); 
    $career_objectives = $config->get('resume_builder.career_objectives')['value'];
    $output .= $career_objectives;
  	return [
      '#type' => 'markup',
      '#markup' => $output
    ];
    return $output;
  }
}