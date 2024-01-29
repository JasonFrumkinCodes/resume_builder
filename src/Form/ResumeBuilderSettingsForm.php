<?php

namespace Drupal\resume_builder\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Module settings form.
 */
class ResumeBuilderSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'resume_builder_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);
    
    // Load current configurations
    $config = $this->config('resume_builder.settings');  
 
    $form['general_info'] = array(
      '#type' => 'details',
      '#title' => $this
        ->t('Your Details'),
      '#open' => FALSE, // Controls the HTML5 'open' attribute. Defaults to FALSE.
    );
    $form['general_info']['applicant_full_name'] = [
      '#type' => 'textfield',
      '#title' => t('Your Full Name'),
      '#default_value' => $config->get('resume_builder.applicant_full_name'),
      '#description' => $this->t('First and Last Name'),
    ];
    $form['general_info']['applicant_email_address'] = [
      '#type' => 'textfield',
      '#title' => t('Your Email Address:'),
      '#default_value' => $config->get('resume_builder.applicant_email_address'),
    ];    
    $form['general_info']['applicant_phone_number'] = [
      '#type' => 'textfield',
      '#title' => t('Your Phone Number:'),
      '#default_value' => $config->get('resume_builder.applicant_phone_number'),
    ];    
    $form['general_info']['applicant_city_state'] = [
      '#type' => 'textfield',
      '#title' => t('City and State in which you reside:'),
      '#default_value' => $config->get('resume_builder.applicant_city_state'),
      '#description' => $this->t('City and State seperated by a comma: i.e. Chicago, IL'),
    ];  
    $form['general_info']['applicant_linkedin_profile'] = [
      '#type' => 'textfield',
      '#title' => t('Linkedin profile URL'),
      '#default_value' => $config->get('resume_builder.applicant_linkedin_profile'),
      '#description' => $this->t('You\'r Linkdein profile URL - Optional'),
    ];        
    $form['general_info']['applicant_github_url'] = [
      '#type' => 'textfield',
      '#title' => t('GitHub public repository URL'),
      '#default_value' => $config->get('resume_builder.applicant_github_url'),
      '#description' => $this->t('You\'r GitHub public repository URL - Optional'),
    ]; 
 
    $form['career_path_details'] = array(
      '#type' => 'details',
      '#title' => $this
        ->t('Job Title & Career Objectives'),
      '#open' => FALSE, // Controls the HTML5 'open' attribute. Defaults to FALSE.
    );
    $form['career_path_details']['career_path_title'] = [
      '#type' => 'textfield',
      '#title' => t('Job Title / Career Path'),
      '#default_value' => $config->get('resume_builder.career_path_title'),
      '#description' => $this->t('Summary words for what you do. If you develop in Drupal, a good career path title would be "Drupal Developer"'),
    ];    
    $form['career_path_details']['career_objectives'] = [
      '#type' => 'text_format',
      '#title' => t('Career Objectives:'),
      '#format' => 'full_html',
      '#default_value' => $config->get('resume_builder.career_objectives')['value'],
      '#description' => $this->t('A paragraph or two about your career objectives, populates section above work history.'),
    ];

    $form['education'] = array(
      '#type' => 'details',
      '#title' => $this
        ->t('Education'),
      '#open' => FALSE, // Controls the HTML5 'open' attribute. Defaults to FALSE.
    );
    $degree_options = array();

    $form['education']['degree_level'] = [
      '#type' => 'select',
      '#title' => $this
        ->t('Highest Level of Education Achieved'),
      '#options' => [
        'select' => 'Education Level',
        'associate\'s_degree' => 'Associate\'s Degree',
        'bachelor\'s_degree' => 'Bachelor\'s Degree',
        'master\'s_degree' => 'Master\'s Degree'
      ],
      '#default_value' => $config->get('resume_builder.degree_level'),
    ];

    $form['education']['bachelors_degree_info'] = array(
      '#type' => 'details',
      '#title' => $this
        ->t('Associate\'s / Bachelor\'s Degree Details'),
      '#open' => TRUE, // Controls the HTML5 'open' attribute. Defaults to FALSE.
      '#states' => [
        'visible' => [
          ':input[name="degree_level"]' => ['!value' => 'select'],
        ],
      ],
    );
    $form['education']['bachelors_degree_info']['bachelor_degree_type'] = [
      '#type' => 'textfield',
      '#size' => '90',
      '#title' => t('Type of Bachelor\'s Degree'),
      '#default_value' => $config->get('resume_builder.bachelor_degree_type'),
      '#description' => $this->t('I.E. Bachelor of Arts, Bachelor of Science, ect.'),
      '#states' => [
        'visible' => [
          ':input[name="degree_level"]' => [
            ['value' => t('bachelor\'s_degree')],
            ['value' => t('master\'s_degree')]
          ],
        ],
      ],
    ]; 
    $form['education']['bachelors_degree_info']['area_of_study'] = [
      '#type' => 'textfield',
      '#size' => '90',
      '#title' => t('Discipline / Area of Study'),
      '#default_value' => $config->get('resume_builder.area_of_study'),
      '#states' => [
        'visible' => [
          ':input[name="degree_level"]' => ['!value' => 'select'],
        ],
      ],
    ];   
    $form['education']['bachelors_degree_info']['school_attended'] = [
      '#type' => 'textfield',
      '#size' => '90',
      '#title' => $this
        ->t('School Attended'),      
      '#placeholder' => 'Where did you achieve this degree (What college did you attend?)',
      '#attributes' => [
        'id' => 'school_attended',
      ],
      '#default_value' => $config->get('resume_builder.school_attended'),
      '#states' => [
        'visible' => [
          ':input[name="degree_level"]' => ['!value' => 'select'],
        ],
      ],
    ];
    $form['education']['bachelors_degree_info']['school_city_state'] = [
      '#type' => 'textfield',
      '#size' => '90',
      '#title' => t('City and State of the School Attended'),
      '#default_value' => $config->get('resume_builder.school_city_state'),
      '#description' => $this->t('City and State seperated by a comma: i.e. Chicago, IL'),
      '#states' => [
        'visible' => [
          ':input[name="degree_level"]' => ['!value' => 'select'],
        ],
      ],
    ];    
    $form['education']['bachelors_degree_info']['education_start_date'] = [
      '#type' => 'date',
      '#title' => $this
        ->t('Education Start Date'),
      '#default_value' => $config->get('resume_builder.education_start_date'),
      '#description' => $this->t('Only month and year are shown on your resume, you can select any date of the month'),
      '#states' => [
        'visible' => [
          ':input[name="degree_level"]' => ['!value' => 'select'],
        ],
      ],
    ];   
    $form['education']['bachelors_degree_info']['education_end_date'] = [
      '#type' => 'date',
      '#title' => $this
        ->t('Graduation Date'),
      '#default_value' => $config->get('resume_builder.education_end_date'),
      '#description' => $this->t('Only month and year are shown on your resume, you can select any date of the month'),
      '#states' => [
        'visible' => [
          ':input[name="degree_level"]' => ['!value' => 'select'],
        ],
      ],      
    ];        

    $form['education']['masters_degree_info'] = array(
      '#type' => 'details',
      '#title' => $this
        ->t('Master\'s Degree Details'),
      '#open' => TRUE, // Controls the HTML5 'open' attribute. Defaults to FALSE.
      '#states' => [
        'visible' => [
          ':input[name="degree_level"]' => ['value' => 'master\'s_degree'],
        ],
      ],
    );
    $form['education']['masters_degree_info']['masters_degree_type'] = [
      '#type' => 'textfield',
      '#size' => '90',
      '#title' => t('Type of Masters\'s Degree'),
      '#default_value' => $config->get('resume_builder.masters_degree_type'),
      '#description' => $this->t('I.E. Master of Science, Master of Business Administration (MBA), ect.'),
      '#placeholder' => 'I.E. Master of Science, Master of Business Administration (MBA), ect.',
    ]; 
    $form['education']['masters_degree_info']['masters_area_of_study'] = [
      '#type' => 'textfield',
      '#size' => '90',
      '#title' => t('Discipline / Area of Study'),
      '#default_value' => $config->get('resume_builder.masters_area_of_study'),
    ]; 
    $form['education']['masters_degree_info']['masters_school_attended'] = [
      '#type' => 'textfield',
      '#size' => '90',
      '#title' => $this
        ->t('School Attended'),      
      '#placeholder' => 'Where did you achieve your Master\'s Degree',
      '#attributes' => [
        'id' => 'school_attended',
      ],
      '#default_value' => $config->get('resume_builder.masters_school_attended'),
    ];
    $form['education']['masters_degree_info']['masters_school_city_state'] = [
      '#type' => 'textfield',
      '#size' => '90',
      '#title' => t('City and State of the School Attended'),
      '#default_value' => $config->get('resume_builder.masters_school_city_state'),
      '#placeholder' => 'City and State seperated by a comma: i.e. Chicago, IL',
    ];    
    $form['education']['masters_degree_info']['masters_start_date'] = [
      '#type' => 'date',
      '#title' => $this
        ->t('Education Start Date'),
      '#default_value' => $config->get('resume_builder.masters_start_date'),
      '#description' => $this->t('Only month and year are shown on your resume, you can select any date of the month'),
    ];   
    $form['education']['masters_degree_info']['masters_end_date'] = [
      '#type' => 'date',
      '#title' => $this
        ->t('Graduation Date'),
      '#default_value' => $config->get('resume_builder.masters_end_date'),
      '#description' => $this->t('Only month and year are shown on your resume, you can select any date of the month'),   
    ];

    return $form;
  }    

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('resume_builder.settings');
    $config->set('resume_builder.career_objectives', $form_state->getValue('career_objectives'));
    $config->set('resume_builder.applicant_email_address', $form_state->getValue('applicant_email_address'));
    $config->set('resume_builder.applicant_full_name', $form_state->getValue('applicant_full_name'));
    $config->set('resume_builder.career_path_title', $form_state->getValue('career_path_title'));
    $config->set('resume_builder.applicant_email_address', $form_state->getValue('applicant_email_address'));
    $config->set('resume_builder.applicant_phone_number', $form_state->getValue('applicant_phone_number'));
    $config->set('resume_builder.applicant_city_state', $form_state->getValue('applicant_city_state'));
    $config->set('resume_builder.applicant_linkedin_profile', $form_state->getValue('applicant_linkedin_profile'));
    $config->set('resume_builder.applicant_github_url', $form_state->getValue('applicant_github_url'));

    $config->set('resume_builder.degree_level', $form_state->getValue('degree_level'));
    $config->set('resume_builder.bachelor_degree_type', $form_state->getValue('bachelor_degree_type'));
    $config->set('resume_builder.area_of_study', $form_state->getValue('area_of_study'));
    $config->set('resume_builder.school_attended', $form_state->getValue('school_attended'));
    $config->set('resume_builder.school_city_state', $form_state->getValue('school_city_state'));
    $config->set('resume_builder.education_start_date', $form_state->getValue('education_start_date'));
    $config->set('resume_builder.education_end_date', $form_state->getValue('education_end_date'));

    $config->set('resume_builder.masters_degree_type', $form_state->getValue('masters_degree_type'));
    $config->set('resume_builder.masters_area_of_study', $form_state->getValue('masters_area_of_study'));
    $config->set('resume_builder.masters_school_attended', $form_state->getValue('masters_school_attended'));
    $config->set('resume_builder.masters_school_city_state', $form_state->getValue('masters_school_city_state'));
    $config->set('resume_builder.masters_start_date', $form_state->getValue('masters_start_date'));
    $config->set('resume_builder.masters_end_date', $form_state->getValue('masters_end_date'));

    $config->save();
    return parent::submitForm($form, $form_state);
  }
  
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'resume_builder.settings',
    ];
  }
}