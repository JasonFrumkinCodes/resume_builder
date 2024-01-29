<?php

namespace Drupal\resume_builder\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Provides a 'Skills' block.
 *
 * @Block(
 *   id = "simple_resume_builder",
 *   admin_label = @Translation("Skills Block")
 * )
 */
class SkillsBlock extends BlockBase {

  public function build() {
    $vid = $this->configuration['taxonomy'];
    $skills_taxonomy = \Drupal::service('entity_type.manager')->getStorage("taxonomy_term")->loadTree($vid);
    $skills = array();
    $output = "<p class='resume_builder_title'>".$this->configuration['block_title']."</p>";
    $output .= "<ul>";
    foreach($skills_taxonomy as $skills_taxonomy_term) {
        $weight = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($skills_taxonomy_term->tid)->get('field_display_weight')->getValue()[0]['value'];
        $skills[(int)$weight] = $skills_taxonomy_term->name;
    }  
    ksort($skills);
    foreach ($skills as $skill_weight => $value) {
    	$output .= "<li>".$value."</li>";
    }
    $output .= "</ul>";
  	return [
      '#type' => 'markup',
      '#markup' => $output
    ];
  }	

  /**
   * {@inheritdoc}
   */  
  public function defaultConfiguration() {
    return [
      'taxonomy' => $this->t(''),
      'block_title' => $this->t(''),
    ];
  }
  
  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    //Load list of available vocabularies.
    $vocabularies = Vocabulary::loadMultiple();
    $vocabulary_list = array();
    foreach($vocabularies as $machine_name => $voc) {
        //get label names of vocabulary.
        $vocabulary_list[$machine_name] = $voc->label();
    }
    $form['taxonomy'] = [
      '#type' => 'select',
      '#title' => $this
        ->t('Select taxonomy term to list in this block'),
      '#options' => $vocabulary_list,
      '#default_value' => $this->configuration['taxonomy'],
    ];

    $form['block_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Add a block title'),
      '#default_value' => $this->configuration['block_title'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->configuration['taxonomy'] = $values['taxonomy'];
    $this->configuration['block_title'] = $values['block_title'];
  }  
}