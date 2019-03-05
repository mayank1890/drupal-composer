<?php

namespace Drupal\video_capability\Plugin\Block;

use Drupal\Component\Utility\Html;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'Video Capability Block' block.
 *
 * @Block(
 *  id = "video_capability_block",
 *  admin_label = @Translation("Video Capability block"),
 * )
 */
class VideoCapability extends BlockBase implements BlockPluginInterface {
  
  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    // If you want to disable caching for this block.
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    //With this when your node change your block will rebuild
    if ($node = \Drupal::routeMatch()->getParameter('node')) {
      //if there is node add its cachetag
      return Cache::mergeTags(parent::getCacheTags(), array('node:' . $node->id()));
    } else {
      //Return default tags instead.
      return parent::getCacheTags();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    //if you depends on \Drupal::routeMatch()
    //you must set context of this block with 'route' context tag.
    //Every new route this block will rebuild
    return Cache::mergeContexts(parent::getCacheContexts(), array('route'));
  }

  /**
   * {@inheritdoc}
   */   
  public function blockForm($form, FormStateInterface $form_state) {

  	$form['video_player_id'] = [
  	  '#type' => 'textfield',
      '#title' => $this->t('Video Id'),
      '#description' => $this->t('Enter the Video Id.'),
      '#default_value' => isset($this->configuration['video_player_id']) ? $this->configuration['video_player_id'] : '',
      '#required' => TRUE,
      '#weight' => 10,
  	];
    $form['video_player_account_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Video Player Account Id'),
      '#description' => $this->t('Enter the Video Account Id.'),
      '#default_value' => isset($this->configuration['video_player_account_id']) ? $this->configuration['video_player_account_id'] : '',
      '#required' => TRUE,
      '#weight' => 20,
    ];
    $form['video_player_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Video Player Name'),
      '#description' => $this->t('Enter the Video Player Name.'),
      '#default_value' => isset($this->configuration['video_player_name']) ? $this->configuration['video_player_name'] : '',
      '#required' => TRUE,
      '#weight' => 30,
    ];
    $form['video_player_height'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Video Player Height'),
      '#description' => $this->t('Enter the Video player height.'),
      '#default_value' => isset($this->configuration['video_player_height']) ? $this->configuration['video_player_height'] : '240',
      '#required' => FALSE,
      '#weight' => 40,
    ];
    $form['video_player_width'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Video Player Width'),
      '#description' => $this->t('Enter the Video player width.'),
      '#default_value' => isset($this->configuration['video_player_width']) ? $this->configuration['video_player_width'] : '426',
      '#required' => FALSE,
      '#weight' => 50,
    ];
  	return $form;
  }

  /**
   * {@inheritdoc}
   */   
  public function blockSubmit($form, FormStateInterface $form_state) {
  	/** @var \Drupal\Core\Form\SubformStateInterface $form_state */
    $this->configuration['machine_name'] = $form_state->getCompleteFormState()
      ->getValue('id');
    $this->configuration['video_player_id'] = $form_state->getValue('video_player_id');
    $this->configuration['video_player_account_id'] = $form_state->getValue('video_player_account_id');
    $this->configuration['video_player_name'] = $form_state->getValue('video_player_name');
    $this->configuration['video_player_height'] = $form_state->getValue('video_player_height');
    $this->configuration['video_player_width'] = $form_state->getValue('video_player_width');
  }

  /**
   * {@inheritdoc}
   */   
  public function blockValidate($form, FormStateInterface $form_state) {
  
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
  $video_block_id = 'video_capability_' . Html::escape($this->configuration['machine_name']);
  $video_player_id = isset($this->configuration['video_player_id']) ? $this->configuration['video_player_id'] : '';
  $video_player_account_id = isset($this->configuration['video_player_account_id']) ? $this->configuration['video_player_account_id'] : '';
  $video_player_name = isset($this->configuration['video_player_name']) ? $this->configuration['video_player_name'] : '';
  $video_player_width = (isset($this->configuration['video_player_width']) ? $this->configuration['video_player_width'] : '426') . 'px';
  $video_player_height = (isset($this->configuration['video_player_height']) ? $this->configuration['video_player_height'] : '240') . 'px';

  $build = [
    '#type' => 'container',
    '#attributes' => [
      'class' => [
        $video_block_id,
        'video_capability__noscript',
      ],
    ],
  ];

  //Render Values
  $build = [
    '#theme' => 'video_capability',
    '#video_player_id' => $video_player_id,
    '#video_player_width' => $video_player_width,
    '#video_player_height' => $video_player_height,
    '#video_player_account_id' => $video_player_account_id,
    '#video_player_name' => $video_player_name,
    '#attached' => [
      'library' => ['video_capability/video_capability'],
      'drupalSettings' =>  [
        'video_capability_' => [
          $video_block_id => [
            'video_player_id' => isset($this->configuration['video_player_id']) ? $this->configuration['video_player_id'] : '',
            'video_player_account_id' => isset($this->configuration['video_player_account_id']) ? $this->configuration['video_player_account_id'] : '',
            'video_player_name' => isset($this->configuration['video_player_name']) ? $this->configuration['video_player_name'] : '',
            'video_player_height' => (isset($this->configuration['video_player_height']) ? $this->configuration['video_player_height'] : '240') . 'px',
            'video_player_width' => (isset($this->configuration['video_player_width']) ? $this->configuration['video_player_width'] : '426') . 'px',
          ],
        ],
      ],
    ],
  ];
  return $build;
  }
}