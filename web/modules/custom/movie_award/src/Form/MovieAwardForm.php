<?php 

namespace Drupal\movie_award\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use function PHPSTORM_META\type;

/**
 * Form handler for the Movie Award add and edit forms.
 */
class MovieAwardForm extends EntityForm {

  protected $entity_type_manager;

  /**
   * Constructs an MovieAwardForm object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entityTypeManager.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entity_type_manager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

   /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $movie_award = $this->entity;
  
    if ($this->entity->get('movie')) {
      foreach ($this->entity->get('movie') as $id => $value ) {
        $temp[] = $value;
      }
    }
   
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $movie_award->label(),
      '#description' => $this->t("Label for the Movie Award."),
      '#required' => TRUE,
    ];

    $form['description'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Description'),
      '#default_value' => $this->entity->get('description'),
      '#description' => $this->t("Description for the movie which is getting awarded."),
      '#required' => TRUE,
    ];

    $form['year'] = [
      '#type' => 'number',
      '#title' => $this->t('Award Year'),
      '#default_value' => $this->entity->get('year'),
      '#description' => $this->t("Year in which the movie got awarded."),
      '#required' => TRUE,
    ];
    

    
    $form['movie'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Movie Reference'),
      '#default_value' => $this->entity->get('movie') ? $this->entity_type_manager->getStorage('node')->load($this->entity->get('movie')[0]['target_id']) : "",
      '#description' => $this->t("Movie"),
      '#required' => TRUE,
      '#target_type' => 'node',
      '#tags' => TRUE,
      '#selection_handler' => 'default',
      '#selection_settings' => [
        'target_bundles' => ['movie_type'],
      ],
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $movie_award->id(),
      '#machine_name' => [
        'exists' => [$this, 'exist'],
      ],
      '#disabled' => !$movie_award->isNew(),
    ];

    return $form;
  }

   /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $form_state->setValue('movie', $form_state->getValue('movie')[0]['target_id']);
    $movie_award = $this->entity;
    $status = $movie_award->save();
    $result = parent::save($form, $form_state);

    if ($status === SAVED_NEW) {
      $this->messenger()->addMessage($this->t('The %label Movie Award created.', [
        '%label' => $movie_award->label(),
      ]));
    }
    else {
      $this->messenger()->addMessage($this->t('The %label Movie Award updated.', [
        '%label' => $movie_award->label(),
      ]));
    }
    $form_state->setRedirect('entity.movie_award.collection');
    return $result;
  }

   /**
   * Helper function to check whether a machine name already exists.
   */
  public function exist($id) {
    $entity = $this->entityTypeManager->getStorage('movie_award')->getQuery()
      ->condition('id', $id)
      ->execute();
    return (bool) $entity;
  }

}
