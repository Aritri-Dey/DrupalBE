<?php

namespace Drupal\service_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\service_module\CurrentUser;
use Drupal\user\Entity\Role;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a custom block.
 *
 * @Block(
 *   id = "service_module_custom_block",
 *   admin_label = @Translation("Service Module Custom Block"),
 *   category = @Translation("Service Block Category")
 * )
 */
class ServiceBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   *   @var object $userRole
   *     Varible to store user role of current user.
   */
  protected $userRole;

  /**
    * Constructs a Drupalist object.
    *
    * @param array $configuration
    *   A configuration array containing information about the plugin instance.
    * @param string $plugin_id
    *   The plugin id for the plugin instance.
    * @param mixed $plugin_definition
    *   The plugin implementation definition.
    * @param \Drupal\Core\Session\AccountInterface $user_role
    *   The user role of current user.
    */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CurrentUser $user_role) {
    $this->userRole = $user_role;
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('service_module.current_user')
    );
  }

  /**
   * {@inheridDoc}
   */
  public function build() {
    $roles = $this->userRole->getRole();
    $role_name = Role::load($roles[1])->label();
    return [
      '#markup' => $this->t('Welcome, '. $role_name),
    ];
  }

}
