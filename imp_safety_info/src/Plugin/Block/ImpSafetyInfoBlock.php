<?php

namespace Drupal\imp_safety_info\Plugin\Block;

use Drupal\Component\Utility\Html;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'Important Safety Information Block' block.
 *
 * @Block(
 *  id = "imp_safety_info_block",
 *  admin_label = @Translation("Important Safety Information block"),
 * )
 */
class ImpSafetyInfoBlock extends BlockBase implements BlockPluginInterface {

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
    // With this when your node change your block will rebuild.
    if ($node = \Drupal::routeMatch()->getParameter('node')) {
      // If there is node add its cachetag.
      return Cache::mergeTags(parent::getCacheTags(), ['node:' . $node->id()]);
    }
    else {
      // Return default tags instead.
      return parent::getCacheTags();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    // If you depends on \Drupal::routeMatch()
    // you must set context of this block with 'route' context tag.
    // Every new route this block will rebuild.
    return Cache::mergeContexts(parent::getCacheContexts(), ['route']);
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['isi_body_description'] = [
      '#type' => 'text_format',
      '#format' => $this->configuration['isi_body_description']['format'],
      '#title' => $this->t('ImpSafetyInfoBlock description'),
      '#description' => $this->t('Enter the ImpSafetyInfo Block description.'),
      '#default_value' => isset($this->configuration['isi_body_description']['value']) ? $this->configuration['isi_body_description']['value'] : '',
      '#weight' => 10,
      '#required' => FALSE,
    ];
    $form['isi_height'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ImpSafetyInfoBlock Height'),
      '#description' => $this->t('Enter the ImpSafetyInfo Block height.'),
      '#default_value' => isset($this->configuration['isi_height']) ? $this->configuration['isi_height'] : '30',
      '#maxlength' => 2,
      '#size' => 10,
      '#required' => TRUE,
      '#weight' => 20,
    ];
    $form['isi_text_padding_left'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ImpSafetyInfoBlock Left Padding'),
      '#description' => $this->t('Enter the ImpSafetyInfo Block Text Padding Value from left.'),
      '#default_value' => isset($this->configuration['isi_text_padding_left']) ? $this->configuration['isi_text_padding_left'] : '20',
      '#maxlength' => 2,
      '#size' => 10,
      '#required' => FALSE,
      '#weight' => 30,
    ];
    $form['isi_text_padding_right'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ImpSafetyInfoBlock Right Padding'),
      '#description' => $this->t('Enter the ImpSafetyInfo Block Text Padding Value from right.'),
      '#default_value' => isset($this->configuration['isi_text_padding_right']) ? $this->configuration['isi_text_padding_right'] : '20',
      '#maxlength' => 2,
      '#size' => 10,
      '#required' => FALSE,
      '#weight' => 40,
    ];
    $form['isi_background_color'] = [
      '#type' => 'color',
      '#title' => $this->t('ISI Background Color'),
      '#description' => $this->t('Select Background Color for ISI block'),
      '#default_value' => isset($this->configuration['isi_background_color']) ? $this->configuration['isi_background_color'] : '#ffffff',
      '#weight' => 50,
      '#required' => FALSE,
    ];
    $form['isi_font_color'] = [
      '#type' => 'color',
      '#title' => $this->t('ISI Font Color'),
      '#description' => $this->t('Select Font Color for ISI block'),
      '#default_value' => isset($this->configuration['isi_font_color']) ? $this->configuration['isi_font_color'] : '#000000',
      '#weight' => 60,
      '#required' => FALSE,
    ];
    $form['isi_border_color'] = [
      '#type' => 'color',
      '#title' => t('ISI Border Color'),
      '#default_value' => isset($this->configuration['isi_border_color']) ? $this->configuration['isi_border_color'] : '#000000',
      '#description' => t('The CSS color applied to the border of the block.<br>Default: #ccc.'),
      '#size' => 60,
      '#weight' => 70,
      '#required' => FALSE,
    ];
    $form['isi_border_style'] = [
      '#type' => 'select',
      '#title' => t('ISI Border Style'),
      '#options' => [
        'none' => t('none'),
        'hidden' => t('hidden'),
        'dotted' => t('dotted'),
        'dashed' => t('dashed'),
        'solid' => t('solid'),
        'double' => t('double'),
        'groove' => t('groove'),
        'ridge' => t('ridge'),
        'inset' => t('inset'),
        'outset' => t('outset'),
        'initial' => t('initial'),
        'inherit' => t('inherit'),
      ],
      '#default_value' => isset($this->configuration['isi_border_style']) ? $this->configuration['isi_border_style'] : 'solid',
      '#description' => t('The type of border applied to the block.<br>Default: solid.'),
      '#weight' => 80,
      '#required' => FALSE,
    ];
    $form['isi_border_width'] = [
      '#type' => 'textfield',
      '#title' => t('ISI Border Width'),
      '#default_value' => isset($this->configuration['isi_border_width']) ? $this->configuration['isi_border_width'] : '0',
      '#description' => t('The amount of pixels for the width of the border line.<br>The unit of measurement is always <em>px</em>, so use numbers only.<br>Default: 1.'),
      '#size' => 60,
      '#weight' => 90,
      '#required' => FALSE,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state) {
    if (!preg_match('/^[0-9]+$/', $form_state->getValue('isi_height'))) {
      $form_state->setErrorByName('isi_height', $this->t('ISI height must be integer.'));
    }
    if (!preg_match('/^[0-9]+$/', $form_state->getValue('isi_text_padding_left'))) {
      $form_state->setErrorByName('isi_text_padding_left', $this->t('ISI padding left must be integer.'));
    }
    if (!preg_match('/^[0-9]+$/', $form_state->getValue('isi_text_padding_right'))) {
      $form_state->setErrorByName('isi_text_padding_right', $this->t('ISI padding right must be integer.'));
    }
    if (!preg_match('/^[0-9]+$/', $form_state->getValue('isi_border_width'))) {
      $form_state->setErrorByName('isi_border_width', $this->t('ISI border width must be integer.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    /** @var \Drupal\Core\Form\SubformStateInterface $form_state */
    $this->configuration['machine_name'] = $form_state->getCompleteFormState()
      ->getValue('id');
    $this->configuration['isi_height'] = $form_state->getValue('isi_height');
    $this->configuration['isi_text_padding_left'] = $form_state->getValue('isi_text_padding_left');
    $this->configuration['isi_text_padding_right'] = $form_state->getValue('isi_text_padding_right');
    $this->configuration['isi_body_description'] = $form_state->getValue('isi_body_description');
    $this->configuration['isi_background_color'] = $form_state->getValue('isi_background_color');
    $this->configuration['isi_font_color'] = $form_state->getValue('isi_font_color');
    $this->configuration['isi_border_color'] = $form_state->getValue('isi_border_color');
    $this->configuration['isi_border_style'] = $form_state->getValue('isi_border_style');
    $this->configuration['isi_border_width'] = $form_state->getValue('isi_border_width');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $isi_block_id = 'imp_safety_info_' . Html::escape($this->configuration['machine_name']);

    // Identify block by class with machine name.
    $build = [
      '#type' => 'container',
      '#attributes' => [
        'class' => [
          $isi_block_id,
          'imp_safety_info__noscript',
        ],
      ],
    ];

    // Include JS to handle popup and hiding.
    $build['#attached']['library'][] = 'imp_safety_info/imp_safety_info';
    // Pass settings to JS.
    $build['#attached']['drupalSettings']['imp_safety_info_'][$isi_block_id] = [
      'isi_height' => (isset($this->configuration['isi_height']) ? $this->configuration['isi_height'] : '30') . '%',
      'isi_text_padding_left' => (isset($this->configuration['isi_text_padding_left']) ? $this->configuration['isi_text_padding_left'] : '20') . 'px',
      'isi_text_padding_right' => (isset($this->configuration['isi_text_padding_right']) ? $this->configuration['isi_text_padding_right'] : '20') . 'px',
      'isi_background_color' => isset($this->configuration['isi_background_color']) ? $this->configuration['isi_background_color'] : '#ffffff',
      'isi_font_color' => isset($this->configuration['isi_font_color']) ? $this->configuration['isi_font_color'] : '#000000',
      'isi_border_color' => isset($this->configuration['isi_border_color']) ? $this->configuration['isi_border_color'] : '#000000',
      'isi_border_style' => isset($this->configuration['isi_border_style']) ? $this->configuration['isi_border_style'] : 'solid',
      'isi_border_width' => (isset($this->configuration['isi_border_width']) ? $this->configuration['isi_border_width'] : '0') . 'px',
    ];

    // Render ISI description.
    $build['imp_safety_info_block_isi_body_description'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => [
          'imp_safety_info__isi_body_description',
        ],
        'title' => [
          Html::escape($this->label()),
        ],
      ],
      '#markup' => check_markup($this->configuration['isi_body_description']['value'], $this->configuration['isi_body_description']['format']),
    ];
    return $build;
  }

}
