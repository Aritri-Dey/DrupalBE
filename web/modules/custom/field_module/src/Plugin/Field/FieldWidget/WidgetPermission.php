<?php

/**
 * @file
 * Contains \Drupal\field_module\Plugin\Field\FieldWidget\WidgetPermission.
 */
namespace Drupal\field_module\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\field_module\CurrentUser;
use Symfony\Component\DependencyInjection\ContainerInterface;


class WidgetPermission extends WidgetBase implements ContainerFactoryPluginInterface {
  
  /**
   *   @var object $userRole
   *     Stores role of user.
   */
  protected $userRole;

  /**
   * Constructs a WidgetBase object.
   *
   * @param string $plugin_id
   *   The plugin_id for the widget.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the widget is associated.
   * @param array $settings
   *   The widget settings.
   * @param array $third_party_settings
   *   Any third party settings.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, array $third_party_settings, CurrentUser $user_role) {
    $this->fieldDefinition = $field_definition;
    $this->settings = $settings;
    $this->thirdPartySettings = $third_party_settings;
    $this->userRole = $user_role;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id, $plugin_definition, 
      $configuration['field_definition'], 
      $configuration['settings'], 
      $configuration['third_party_settings'],
      $container->get('field_module.current_user')
    );
  }


  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form,FormStateInterface $form_state) {
    return $element;
  }

}
