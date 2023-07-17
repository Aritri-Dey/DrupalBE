<?php

namespace Drupal\block_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\user\Entity\Role;
/**
 * Provides a custom block.
 *
 * @Block(
 *   id = "block_module_custom_block",
 *   admin_label = @Translation("Block Module"),
 *   category = @Translation("Custom Block Category")
 * )
 */
class CustomBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $roles = \Drupal::currentUser()->getRoles();
    $role_name = Role::load($roles[1])->label();
    return [
        '#markup' => $this->t('Welcome, '. $role_name),
    ];
  }

}
