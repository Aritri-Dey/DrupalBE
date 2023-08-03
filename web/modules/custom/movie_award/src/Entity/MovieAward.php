<?php 

namespace Drupal\movie_award\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\movie_award\MovieAwardInterface;

/**
 * Defines the Movie Award configuration entity.
 *
 * @ConfigEntityType(
 *   id = "movie_award",
 *   label = @Translation("Movie Award"),
 *   handlers = {
 *     "list_builder" = "Drupal\movie_award\Controller\MovieAwardListBuilder",
 *     "form" = {
 *       "add" = "Drupal\movie_award\Form\MovieAwardForm",
 *       "edit" = "Drupal\movie_award\Form\MovieAwardForm",
 *       "delete" = "Drupal\movie_award\Form\MovieAwardDeleteForm",
 *     }
 *   },
 *   config_prefix = "movie_award",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *     "year",
 *     "movie"
 *   },
 *   links = {
 *     "edit-form" = "/admin/config/system/movie_award/{movie_award}",
 *     "delete-form" = "/admin/config/system/movie_award/{movie_award}/delete",
 *   }
 * )
 */
class MovieAward extends ConfigEntityBase implements MovieAwardInterface {

  /**
   * The Movie Award ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Movie Award label.
   *
   * @var string
   */
  protected $label;

  /**
   * The Movie Award description.
   *
   * @var string
   */
  protected $description;

  /**
   * The Movie Award year.
   *
   * @var string
   */
  protected $year;

  /**
   * The referenced Movie.
   *
   * @var string
   */
  protected $movie;

  /**
   * Gets the description property.
   *
   * @return string $description
   *   The description property.
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Sets the description property.
   *
   * @param string $description
   *   The description property.
   *
   * @return $this
   */
  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

  /**
   * Gets the year property.
   *
   * @return string 
   *   The description property.
   */
  public function getYear() {
    return $this->year;
  }

  /**
   * Sets the year property.
   *
   * @param string $year
   *   The year property.
   *
   * @return $this
   */
  public function setYear($year) {
    $this->year = $year;
    return $this;
  }

  /**
   * Gets the movie property.
   *
   * @param array $movie
   *   The movie property.
   *
   * @return array $this 
   */
  public function getMovie() {
    return $this->movie;
  }

  /**
   * Sets the movie property.
   *
   * @param string $movie
   *   The movie property.
   *
   * @return $this
   */
  public function setMovie($movie) {
    $this->movie = $movie; 
    return $this;
  }

}
