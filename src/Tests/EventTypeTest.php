<?php

/**
 * @file
 * Contains \Drupal\rng\Tests\EventTypeTest.
 */

namespace Drupal\rng\Tests;

use Drupal\rng\Entity\EventTypeConfig;
use Drupal\node\Entity\NodeType;
use Drupal\Core\Url;

/**
 * Tests EventTypeConfig
 *
 * @group RNG
 */
class EventTypeTest extends RNGTestBase {

  public static $modules = array('node');

  public static function getInfo() {
    return array(
      'name' => 'Event Types',
      'description' => 'Event Types',
      'group' => 'RNG',
    );
  }

  function testEventType() {
    $web_user = $this->drupalCreateUser(['administer event types', 'access administration pages']);
    $this->drupalLogin($web_user);

    // Event types button on admin
    $this->drupalGet('admin/config');
    $this->assertLinkByHref(Url::fromRoute('rng.event_type_config.overview')->toString());
    $this->assertRaw('Manage which entity bundles are designated as events.', 'Button shows in administration.');

    // No events
    $this->assertEqual(0, count(EventTypeConfig::loadMultiple()), 'There are no event type entities.');
    $this->drupalGet('admin/config/rng/event_types');
    $this->assertRaw('There is no Event configuration type yet.', 'Event Type list is empty');

    // Local action
    $this->assertLinkByHref(Url::fromRoute('entity.event_type_config.add')->toString());

    // Add
    // @todo local action shows
    $t_args = ['%label' => 'node.event'];
    $edit = [];
    $this->drupalPostForm('admin/config/rng/event_types/add', $edit, t('Save'));
    $node_type = NodeType::load('event');

    $this->assertEqual(1, count(EventTypeConfig::loadMultiple()), 'Event type exists in database.');
    $this->assertRaw(t('The content type !link has been added.', ['!link' => $node_type->link()]), 'Node was created for Event Type');
    $this->assertRaw(t('%label event type added.', $t_args), 'Event Type created');

    // Event type list
    $this->assertUrl('admin/config/rng/event_types', [], 'Browser was redirected to event type list.');
    $this->assertRaw('<td>node.event</td>', 'Event Type shows in list');

    // Edit form
    $edit = [];
    $this->drupalPostForm('admin/config/rng/event_types/manage/node.event/edit', $edit, t('Save'));
    $this->assertRaw(t('%label event type updated.', $t_args), 'Event Type edit form saved');

    // Delete form
    $this->drupalGet('admin/config/rng/event_types/manage/node.event/delete');
    $this->assertRaw('Are you sure you want to delete settings for event node.event and all associated registrations?', 'Event Type delete form rendered.');

    $this->drupalPostForm('admin/config/rng/event_types/manage/node.event/delete', [], t('Delete'));
    $this->assertRaw(t('Event type %label was deleted.', $t_args), 'Event Type delete form saved');

    $this->assertEqual(0, count(EventTypeConfig::loadMultiple()), 'Event type deleted from database.');

    // @todo: ensure conditional on form omits node/existing radios
    // @todo create event type with custom entity
  }

}