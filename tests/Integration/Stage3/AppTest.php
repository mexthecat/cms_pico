<?php
/**
 * CMS Pico - Create websites using Pico CMS for Nextcloud.
 *
 * @copyright Copyright (c) 2020, Daniel Rudolf (<picocms.org@daniel-rudolf.de>)
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace OCA\CMSPico\Tests\Integration\Stage3;

use OCA\CMSPico\AppInfo\Application;
use OCA\CMSPico\Tests\TestCase;
use OCP\App\IAppManager;

/**
 * @group IntegrationStage3
 */
class AppTest extends TestCase
{
	/** @var IAppManager */
	private $appManager;

	protected function setUp(): void
	{
		parent::setUp();

		$this->appManager = \OC::$server->query(IAppManager::class);
	}

	public function testAppInstalled()
	{
		$this->assertTrue($this->appManager->isInstalled(Application::APP_NAME));
	}
}
