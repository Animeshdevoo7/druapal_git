<?php
 
namespace Drupal\hook\Plugin\WebformHandler;
 
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\media\Entity\Media;
use Drupal\file\Entity\File;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface;
 
/**
 * Create a new node entity from a webform submission.
 *
 * @WebformHandler(
 *   id = "media_creater",
 *   label = @Translation("media_creater"),
 *   category = @Translation("Entity Creation"),
 *   description = @Translation("new media created"),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */
 
 class SubmitHandler extends WebformHandlerBase {
  
  public function postSave(WebformSubmissionInterface $webform_submission, $update = TRUE) {
    $file_field_name = 'myupload';
    if (!empty($webform_submission->getData($file_field_name))) {
      $file = File::load($webform_submission->getData($file_field_name)['myupload']);
      
      if ($file) {
        $file_type = $file->getMimeType();

        if (strpos($file_type, 'audio/') === 0) {
          $this->createMedia('audio', 'field_media_audio_file', $file);
          $this->messenger()->addMessage($this->t('Audio File Created'), 'status', TRUE);
        }
        elseif (strpos($file_type, 'image/') === 0) {
          $this->createMedia('image', 'field_media_image', $file);
          $this->messenger()->addMessage($this->t('Image File Created'), 'status', TRUE);
        }
        elseif ($file_type === 'application/pdf') {
          $this->createMedia('pdf', 'field_media_pdf_file', $file);
          $this->messenger()->addMessage($this->t('Pdf File Created'), 'status', TRUE);
        }
        else {
          $this->createMedia('default', 'field_media_default_file', $file);
        }
      }
    }
  }
  private function createMedia($bundle, $field_name, $file) {
    $media = Media::create([
      'bundle' => $bundle,
      'uid' => 1, 
      'name' => $file->getFiename(),
      $field_name => [
        'target_id' => $file->id(),
      ],
    ]);
    $media->save();
  }
}











