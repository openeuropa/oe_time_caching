<?php

declare(strict_types = 1);

namespace Drupal\Tests\oe_time_caching\Unit\Cache;

use Drupal\oe_time_caching\Cache\TimeBasedCacheTagGenerator;
use Drupal\Tests\UnitTestCase;

/**
 * Test the generation of Drupal time-based cache tags.
 */
class TimeBasedCacheTagGeneratorTest extends UnitTestCase {

  /**
   * Test the generation a list of tags.
   */
  public function testGenerateTags() {
    // Tags are based on the time in UTC timezone.
    $expected = [
      'oe_time_caching_date:2020',
      'oe_time_caching_date:2020-02',
      'oe_time_caching_date:2020-02-15',
      'oe_time_caching_date:2020-02-15-01',
    ];

    // Australia/Sydney timezone is used by default in tests.
    $date = \DateTime::createFromFormat('Y-m-d H:i:s', '2020-02-15 12:35:13');
    $this->assertEquals($expected, (new TimeBasedCacheTagGenerator())->generateTags($date));

    // Assert tags for date in the America/New_York timezone.
    $date->setTimezone(new \DateTimeZone('America/New_York'));
    $this->assertEquals($expected, (new TimeBasedCacheTagGenerator())->generateTags($date));
  }

  /**
   * Test the generation a list of tags, up until midnight.
   */
  public function testGenerateTagsUntilMidnight() {
    // Tags are based on the time in UTC timezone.
    $expected = [
      'oe_time_caching_date:2020',
      'oe_time_caching_date:2020-02',
      'oe_time_caching_date:2020-02-15',
      'oe_time_caching_date:2020-02-15-00',
    ];

    // Date in Australia/Sydney timezone.
    $date = \DateTime::createFromFormat('Y-m-d H:i:s', '2020-02-15 12:35:13');
    $this->assertEquals($expected, (new TimeBasedCacheTagGenerator())->generateTagsUntilMidnight($date));

    // Assert tags for date in the America/New_York timezone.
    $date->setTimezone(new \DateTimeZone('America/New_York'));
    $this->assertEquals($expected, (new TimeBasedCacheTagGenerator())->generateTagsUntilMidnight($date));
  }

  /**
   * Test the generation of a list invalidating tags.
   */
  public function testGenerateInvalidatingTags() {
    // Tags are based on the time in UTC timezone.
    $expected = [
      'oe_time_caching_date:2015',
      'oe_time_caching_date:2016',
      'oe_time_caching_date:2017',
      'oe_time_caching_date:2018',
      'oe_time_caching_date:2019',
      'oe_time_caching_date:2020-01',
      'oe_time_caching_date:2020-02-01',
      'oe_time_caching_date:2020-02-02',
      'oe_time_caching_date:2020-02-03',
      'oe_time_caching_date:2020-02-04',
      'oe_time_caching_date:2020-02-05',
      'oe_time_caching_date:2020-02-06',
      'oe_time_caching_date:2020-02-07',
      'oe_time_caching_date:2020-02-08',
      'oe_time_caching_date:2020-02-09',
      'oe_time_caching_date:2020-02-10',
      'oe_time_caching_date:2020-02-11',
      'oe_time_caching_date:2020-02-12',
      'oe_time_caching_date:2020-02-13',
      'oe_time_caching_date:2020-02-14',
      'oe_time_caching_date:2020-02-15-00',
      'oe_time_caching_date:2020-02-15-01',
    ];

    // Date in Australia/Sydney timezone.
    $date = \DateTime::createFromFormat('Y-m-d H:i:s', '2020-02-15 12:35:13');
    $this->assertEquals($expected, (new TimeBasedCacheTagGenerator())->generateInvalidatingTags($date));

    // Assert tags for date in the America/New_York timezone.
    $date->setTimezone(new \DateTimeZone('America/New_York'));
    $this->assertEquals($expected, (new TimeBasedCacheTagGenerator())->generateInvalidatingTags($date));
  }

}
