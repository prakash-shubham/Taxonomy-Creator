<?php  
/**
 * @file
 * Contains \Drupal\newmod\Plugin\QueueWorker\GetJson.
 */

namespace Drupal\newmod\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\Component\Serialization\Json;
use Drupal\taxonomy\Entity\Term;
/**
 * Processes tasks for example module.
 *
 * @QueueWorker(
 *   id = "get_json",
 *   title = @Translation("Get Json"),
 *   cron = {"time" = 90}
 * )
 */
class GetJson extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
	public function processItem($decoded_data) {

		foreach ($decoded_data as $value) {

			$category_id = $value['category_id'];
			$parent_category_id = $value['parent_category_id'];
			$category_name = $value['category_name'];
				
			$term = \Drupal::entityTypeManager()
	     	->getStorage('taxonomy_term')
	     	->loadByProperties(['field_category_id' => $category_id]);

			if(empty($term)) {
				$tid = 0;
				if($parent_category_id != 0) {

					$term = \Drupal::entityTypeManager()
	     			->getStorage('taxonomy_term')
	     			->loadByProperties(['field_category_id' => $parent_category_id]);

					$term = reset ($term);
					$tid= $term->id();
				}

				//Creating Terms in Vocabulary
				$term2 = Term::create([
		  		'name' => $category_name,
		  		'field_category_id' => $category_id,
		  		'field_parent_category_id' => $parent_category_id,
        	'parent' => $tid,
		  		'vid' => 'newvoc',
				])->save();
			}
		}
  }
}