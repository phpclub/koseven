<?php

/**
 * Tests the View class
 *
 * @group kohana
 * @group kohana.core
 * @group kohana.core.view
 *
 * @package    Kohana
 * @category   Tests
 * @author     Kohana Team
 * @copyright  (c) Kohana Team
 * @license    https://koseven.ga/LICENSE.md
 */
class Kohana_ViewTest extends Unittest_TestCase
{
	protected static $old_modules = [];

	/**
	 * Setups the filesystem for test view files
	 *
	 * @return null
	 */
	// @codingStandardsIgnoreStart
	public static function setupBeforeClass(): void
		// @codingStandardsIgnoreEnd
	{
		self::$old_modules = Kohana::modules();

		$new_modules = self::$old_modules+[
			'test_views' => realpath(dirname(__FILE__).'/../test_data/')
		];
		Kohana::modules($new_modules);
	}

	/**
	 * Restores the module list
	 *
	 * @return null
	 */
	// @codingStandardsIgnoreStart
	public static function teardownAfterClass(): void
		// @codingStandardsIgnoreEnd
	{
		Kohana::modules(self::$old_modules);
	}

	/**
	 * Provider for test_instaniate
	 *
	 * @return array
	 */
	public function provider_instantiate()
	{
		return [
			['kohana/error', FALSE],
			['test.css', FALSE],
			['doesnt_exist', TRUE],
		];
	}

	/**
	 * Provider to test_set
	 *
	 * @return array
	 */
	public function provider_set()
	{
		return [
			['foo', 'bar', 'foo', 'bar'],
			[['foo' => 'bar'], NULL, 'foo', 'bar'],
			[new ArrayIterator(['foo' => 'bar']), NULL, 'foo', 'bar'],
		];
	}

	/**
	 * Tests that we can instantiate a view file
	 *
	 * @test
	 * @dataProvider provider_instantiate
	 *
	 * @return null
	 */
	public function test_instantiate($path, $expects_exception)
	{
		try
		{
			$view = new View($path);
			$this->assertSame(FALSE, $expects_exception);
		}
		catch(View_Exception $e)
		{
			$this->assertSame(TRUE, $expects_exception);
		}
	}

	/**
	 * Tests that we can set using string, array or Traversable object
	 *
	 * @test
	 * @dataProvider provider_set
	 *
	 * @return null
	 */
	public function test_set($data_key, $value, $test_key, $expected)
	{
		$view = View::factory()->set($data_key, $value);
		$this->assertSame($expected, $view->$test_key);
	}

	/**
	 * Tests that we can set global using string, array or Traversable object
	 *
	 * @test
	 * @dataProvider provider_set
	 *
	 * @return null
	 */
	public function test_set_global($data_key, $value, $test_key, $expected)
	{
		$view = View::factory();
		$view::set_global($data_key, $value);
		$this->assertSame($expected, $view->$test_key);
	}
}
