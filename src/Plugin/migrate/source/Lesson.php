<?php

/**
 * @file
 * Contains \Drupal\migrate_drupal7\Plugin\migrate\source\Node.
 */

namespace Drupal\migrate_drupal7\Plugin\migrate\source;

use Drupal\migrate\Plugin\SourceEntityInterface;
use Drupal\migrate\Row;
use Drupal\migrate_drupal7\Plugin\migrate\source\DrupalSqlBase;

/**
 * Drupal 7 Lesson node source from database.
 *
 * @MigrateSource(
 *   id = "d7_lesson"
 * )
 */
class Lesson extends DrupalSqlBase implements SourceEntityInterface {

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Select node in its last revision.
    $query = $this->select('node', 'n')
      ->condition('n.type', 'lesson', '=')
      ->fields('n', array(
        'nid',
        'vid',
        'type',
        'language',
        'title',
        'uid',
        'status',
        'created',
        'changed',
        'promote',
        'sticky',
        'uuid',
      ));
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = $this->baseFields();
    //field_lesson_description
    $fields['field_lesson_description_value'] = $this->t('Value of field_lesson_description');
    $fields['field_lesson_description_format'] = $this->t('format of the value of field_lesson_description');
    //field_lesson_prerequisites
    $fields['field_lesson_prerequisites_value'] = $this->t('Value of field_lesson_prerequisites');
    $fields['field_lesson_prerequisites_format'] = $this->t('format of the value of field_lesson_prerequisites');    
    //field_lesson_overview
    $fields['field_lesson_overview_value'] = $this->t('Value of field_lesson_overview');
    $fields['field_lesson_overview_format'] = $this->t('format of the value of field_lesson_overview');
    //field_lesson_steps
    $fields['field_lesson_steps_value'] = $this->t('Value of field_lesson_steps');
    $fields['field_lesson_steps_format'] = $this->t('format of the value of field_lesson_steps');
    //field_lesson_project_name
    $fields['field_lesson_project_name_value'] = $this->t('Value of field_lesson_project_name');
    $fields['field_lesson_project_name_format'] = $this->t('format of the value of field_lesson_project_name');
    //field_lesson_draft_status
    $fields['field_lesson_draft_status_value'] = $this->t('Value of field_lesson_draft_status');
    //field_lesson_type
    $fields['field_lesson_type_value'] = $this->t('Value of field_lesson_type');    
    //field_lesson_project_type
    $fields['field_lesson_project_type_value'] = $this->t('Value of field_lesson_project_type');
    //field_lesson_last_peer_review
    $fields['field_lesson_last_peer_review_value'] = $this->t('Value of field_lesson_last_peer_review');
    //field_lesson_drupal_version
    $fields['field_lesson_drupal_version_value'] = $this->t('Value of field_lesson_drupal_version');    
    //field_lesson_maintainers
    //field_lesson_tags


    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $nid = $row->getSourceProperty('nid');
    
    //field_lesson_description
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_lesson_description_value,
        fld.field_lesson_description_format
      FROM
        {field_data_field_lesson_description} fld
      WHERE
        fld.entity_id = :nid
    ', array(':nid' => $nid));
    //ASSUMPTION: assuming that there will be only one record/row as a result from above query.
    foreach ($result as $record) {
      $row->setSourceProperty('field_lesson_description_value', $record->field_lesson_description_value );
      $row->setSourceProperty('field_lesson_description_format', $record->field_lesson_description_format );
    }

    
    //field_lesson_prerequisites
    $result = $this->getDatabase()->query('
      SELECT
        flo.field_lesson_prerequisites_value,
        flo.field_lesson_prerequisites_format
      FROM
        {field_data_field_lesson_prerequisites} flo
      WHERE
        flo.entity_id = :nid
    ', array(':nid' => $nid));
    //ASSUMPTION: assuming that there will be only one record/row as a result from above query.
    foreach ($result as $record) {
      $row->setSourceProperty('field_lesson_prerequisites_value', $record->field_lesson_prerequisites_value );
      $row->setSourceProperty('field_lesson_prerequisites_format', $record->field_lesson_prerequisites_format );
    }

     
    //field_lesson_overview
    $result = $this->getDatabase()->query('
      SELECT
        flo.field_lesson_overview_value,
        flo.field_lesson_overview_format
      FROM
        {field_data_field_lesson_overview} flo
      WHERE
        flo.entity_id = :nid
    ', array(':nid' => $nid));
    //ASSUMPTION: assuming that there will be only one record/row as a result from above query.
    foreach ($result as $record) {
      $row->setSourceProperty('field_lesson_overview_value', $record->field_lesson_overview_value );
      $row->setSourceProperty('field_lesson_overview_format', $record->field_lesson_overview_format );
    }

    //field_lesson_steps
    $result = $this->getDatabase()->query('
      SELECT
        fls.field_lesson_steps_value,
        fls.field_lesson_steps_format
      FROM
        {field_data_field_lesson_steps} fls
      WHERE
        fls.entity_id = :nid
    ', array(':nid' => $nid));
    //ASSUMPTION: assuming that there will be only one record/row as a result from above query.
    foreach ($result as $record) {
      $row->setSourceProperty('field_lesson_steps_value', $record->field_lesson_steps_value );
      $row->setSourceProperty('field_lesson_steps_format', $record->field_lesson_steps_format );
    }
   
    //field_lesson_draft_status
    $result = $this->getDatabase()->query('
      SELECT
        flds.field_lesson_draft_status_value
      FROM
        {field_data_field_lesson_draft_status} flds
      WHERE
        flds.entity_id = :nid
    ', array(':nid' => $nid));
    //ASSUMPTION: assuming that there will be only one record/row as a result from above query.
    foreach ($result as $record) {
      $row->setSourceProperty('field_lesson_draft_status_value', $record->field_lesson_draft_status_value );
    }
    
    
    //field_lesson_project_type
    $result = $this->getDatabase()->query('
      SELECT
        lpt.field_lesson_project_type_value
      FROM
        {field_data_field_lesson_project_type} lpt
      WHERE
        lpt.entity_id = :nid
    ', array(':nid' => $nid));
    //ASSUMPTION: assuming that there will be only one record/row as a result from above query.
    foreach ($result as $record) {
      $row->setSourceProperty('field_lesson_project_type_value', $record->field_lesson_project_type_value );
    }
    
    //field_lesson_type
    $result = $this->getDatabase()->query('
      SELECT
        flt.field_lesson_type_value
      FROM
        {field_data_field_lesson_type} flt
      WHERE
        flt.entity_id = :nid
    ', array(':nid' => $nid));
    //ASSUMPTION: assuming that there will be only one record/row as a result from above query.
    foreach ($result as $record) {
      $row->setSourceProperty('field_lesson_type_value', $record->field_lesson_type_value );
    }

    //field_lesson_drupal_version
    $result = $this->getDatabase()->query('
      SELECT
        fldv.field_lesson_drupal_version_value
      FROM
        {field_data_field_lesson_drupal_version} fldv
      WHERE
        fldv.entity_id = :nid
    ', array(':nid' => $nid));
    //This field is a multi-value field => above query will result in multiple rows.
   /* Method 2: $multiplevalues = array();
    foreach ($result as $record) {
    	$multiplevalues[] = $record->field_lesson_drupal_version_value;
	*/
    foreach ($result as $record) {
      $row->setSourceProperty('field_lesson_drupal_version_value', $record->field_lesson_drupal_version_value );
      	//Method 3:
    	//As per line 152,153 of \Drupal\migrate_drupal\Plugin\migrate\source\d6\CckFieldValues
   		//$sourceProperty = 'field_lesson_drupal_version.'.$record->delta.'.value';
    	//$row->setSourceProperty($sourceProperty, $record->field_lesson_drupal_version_value );
    }
    // Method 2: $row->setSourceProperty('field_lesson_drupal_version_value', $multiplevalues );
    
    //field_lesson_last_peer_review
    $result = $this->getDatabase()->query('
      SELECT
        lpr.field_lesson_last_peer_review_value
      FROM
        {field_data_field_lesson_last_peer_review} lpr
      WHERE
        lpr.entity_id = :nid
    ', array(':nid' => $nid));
    //ASSUMPTION: assuming that there will be only one record/row as a result from above query.
    foreach ($result as $record) {
      $row->setSourceProperty('field_lesson_last_peer_review_value', $record->field_lesson_last_peer_review_value );
    }

    //field_lesson_project
    $result = $this->getDatabase()->query('
      SELECT
        flp.field_lesson_project_name_value,
        flp.field_lesson_project_name_format
      FROM
        {field_data_field_lesson_project_name} flp
      WHERE
        flp.entity_id = :nid
    ', array(':nid' => $nid));
    //ASSUMPTION: assuming that there will be only one record/row as a result from above query.
    foreach ($result as $record) {
      $row->setSourceProperty('field_lesson_project_name_value', $record->field_lesson_project_name_value );
      $row->setSourceProperty('field_lesson_project_name_format', $record->field_lesson_project_name_format );      
    }    
    return parent::prepareRow($row);
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    $ids['nid']['type'] = 'integer';
    $ids['nid']['alias'] = 'n';
    return $ids;
  }


  /**
   * {@inheritdoc}
   */
  public function bundleMigrationRequired() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function entityTypeId() {
    return 'node';
  }

  /**
   * Returns the user base fields to be migrated.
   *
   * @return array
   *   Associative array having field name as key and description as value.
   */
  protected function baseFields() {
    $fields = array(
      'nid' => $this->t('Node ID'),
      'vid' => $this->t('Version ID'),
      'type' => $this->t('Type'),
      'title' => $this->t('Title'),
      'format' => $this->t('Format'),
      'teaser' => $this->t('Teaser'),
      'uid' => $this->t('Authored by (uid)'),
      'created' => $this->t('Created timestamp'),
      'changed' => $this->t('Modified timestamp'),
      'status' => $this->t('Published'),
      'promote' => $this->t('Promoted to front page'),
      'sticky' => $this->t('Sticky at top of lists'),
      'uuid' => $this->t('Universally Unique ID'),
      'language' => $this->t('Language (fr, en, ...)'),
    );
    return $fields;
  }

}
