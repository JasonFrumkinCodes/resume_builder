<?php

namespace Drupal\resume_builder\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Education Details' block.
 *
 * @Block(
 *   id = "education_details_block",
 *   admin_label = @Translation("Education Details")
 * )
 */
class EducationBlock extends BlockBase {

  public function build() {
    $output = '';
    $config = \Drupal::config('resume_builder.settings'); 
    $degree_type = str_replace("_", " ", $config->get('resume_builder.degree_type'));
    $area_of_study = $config->get('resume_builder.area_of_study');
    $school_attended = $config->get('resume_builder.school_attended');
    $school_city_state = $config->get('resume_builder.school_city_state');
    $education_start_date = $config->get('resume_builder.education_start_date');
    $education_end_date = $config->get('resume_builder.education_end_date');
    $output .= "<div id='education_details'>";
        $output .= "<div class='degree_type'>".$degree_type."</div>";
        $output .= "<div class='area_of_study'>".$area_of_study."</div>";
        $output .= "<div class='school_attended mb-2'>".$school_attended."</div>";
        if($education_start_date && $education_end_date){
          $education_start_date = date_create($education_start_date);
          $education_end_date = date_create($education_end_date);
          $output .= "<div class='attended_dates mb-2'><i class='fa-solid fa-calendar-days'></i>".date_format($education_start_date,"F Y")." - ".date_format($education_end_date,"F Y")."</div>";
          $output .= "<div class='school_city_state'><i class='fa-solid fa-location-dot'></i><div class='linkedin_profile'>".$school_city_state."</div></div>";
        }
    $output .= "</div>";
  	return [
      '#type' => 'markup',
      '#markup' => $output
    ];
    return $output;
  }
}