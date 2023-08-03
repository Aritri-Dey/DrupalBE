<?php 

namespace Drupal\movie_award;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining the Movie Award entity.
 */
interface MovieAwardInterface extends ConfigEntityInterface {  

  /**
   * Function to the get the value of description field.
   * 
   *   @return string 
   */
  public function getDescription();
  
  /**
   * Function to set the value of the description field.
   *
   *   @param  string $description
   *   @return string
   */
  public function setDescription($description);  

  /**
   * Function to get the value of the year field.
   *
   *   @return string
   */
  public function getYear();

  /**
   * Function to set the value of the year field.
   *
   *   @param  string $year
   *   @return string
   */
  public function setYear($year);

  /**
   * Function to get the value of the movie field.
   *
   *   @return array
   */
  public function getMovie();

  /**
   * Function to set the value of the movie field.
   *
   *   @param  array $movie
   *   @return array
   */
  public function setMovie($movie);
  
}
