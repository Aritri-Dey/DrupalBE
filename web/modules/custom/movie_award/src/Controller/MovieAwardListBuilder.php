<?php 

namespace Drupal\movie_award\Controller;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\movie_award\Entity\MovieAward;
use Drupal\movie_award\Form\MovieAwardForm;

/**
 * Provides a listing of Movie Award.
 */
class MovieAwardListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Movie Award');
    $header['id'] = $this->t('Machine name');
    $header['year'] = $this->t('Year');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['label'] = $entity->label();
    $row['id'] = $entity->id();
    $row['year'] = $entity->getYear();
    return $row + parent::buildRow($entity);
  }

}
