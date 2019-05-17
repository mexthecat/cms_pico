<?php
/**
 * CMS Pico - Create websites using Pico CMS for Nextcloud.
 *
 * @copyright Copyright (c) 2017, Maxence Lange (<maxence@artificial-owl.com>)
 * @copyright Copyright (c) 2019, Daniel Rudolf (<picocms.org@daniel-rudolf.de>)
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

namespace OCA\CMSPico\Service;

use OC\App\AppManager;
use OCA\CMSPico\AppInfo\Application;
use OCA\CMSPico\Exceptions\ThemeNotFoundException;
use OCP\IL10N;

class ThemesService
{
	const THEMES = ['default'];

	/** @var AppManager */
	private $appManager;

	/** @var IL10N */
	private $l10n;

	/** @var ConfigService */
	private $configService;

	/** @var FileService */
	private $fileService;

	/** @var MiscService */
	private $miscService;

	/**
	 * ThemesService constructor.
	 *
	 * @param AppManager $appManager
	 * @param IL10N $l10n
	 * @param ConfigService $configService
	 * @param FileService $fileService
	 * @param MiscService $miscService
	 */
	function __construct(
		AppManager $appManager,
		IL10N $l10n,
		ConfigService $configService,
		FileService $fileService,
		MiscService $miscService
	) {
		$this->appManager = $appManager;
		$this->l10n = $l10n;
		$this->configService = $configService;
		$this->fileService = $fileService;
		$this->miscService = $miscService;
	}


	/**
	 * getThemesList();
	 *
	 * returns all available themes.
	 *
	 * @param bool $customOnly
	 *
	 * @return array
	 */
	public function getThemesList($customOnly = false) {
		$themes = [];
		if ($customOnly !== true) {
			$themes = self::THEMES;
		}

		$customs = json_decode($this->configService->getAppValue(ConfigService::CUSTOM_THEMES), true);
		if ($customs !== null) {
			$themes = array_merge($themes, $customs);
		}

		return $themes;
	}


	/**
	 * Check if a theme exist.
	 *
	 * @param $theme
	 *
	 * @return void
	 * @throws ThemeNotFoundException
	 */
	public function assertValidTheme($theme)
	{
		$themes = $this->getThemesList();
		if (!in_array($theme, $themes)) {
			throw new ThemeNotFoundException();
		}
	}


	/**
	 * returns theme from the Pico/themes/ dir that are not available yet to users.
	 *
	 * @return array
	 */
	public function getNewThemesList() {

		$newThemes = [];
		$currThemes = $this->getThemesList();
		$allThemes = $this->fileService->getDirectoriesFromAppDataFolder(PicoService::DIR_THEMES);

		foreach ($allThemes as $theme) {
			if (!in_array($theme, $currThemes)) {
				$newThemes[] = $theme;
			}
		}

		return $newThemes;
	}

	/**
	 * @return string
	 */
	public function getThemesPath() : string
	{
		$appPath = $this->appManager->getAppPath(Application::APP_NAME);
		return $appPath . '/Pico/' . PicoService::DIR_THEMES . '/';
	}

	/**
	 * @return string
	 */
	public function getThemesUrl() : string
	{
		return \OC_App::getAppWebPath(Application::APP_NAME) . '/Pico/' . PicoService::DIR_THEMES . '/';
	}
}
