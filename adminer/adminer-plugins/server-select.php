<?php

/** Vyber "Aktualni server" v levem panelu jako v phpMyAdmin.
* Seznam serveru bere z pluginu AdminerLoginServers (adminer-plugins.php).
* Na server, kde uz jste prihlaseni, prepne rovnou; jinak otevre prihlaseni s predvybranym serverem.
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerServerSelect extends Adminer\Plugin {
	function databasesPrint($missing) {
		$servers = $this->loginServers();
		if (!$servers) {
			return null;
		}
		$base = preg_replace('~\?.*~', '', Adminer\relative_uri());
		$pwds = (array) $_SESSION["pwds"];

		echo "<div id='serverselect'><label for='serverselect-select'>Aktuální server:</label>"
			. "<select id='serverselect-select'>\n";
		foreach ($servers as $name => $server) {
			$driver = $server["driver"];
			$url = $base . "?" . Adminer\url_escape($driver) . "=" . Adminer\url_escape($name);
			$loggedIn = false;
			foreach ((array) $pwds[$driver][$name] as $username => $password) {
				if ($password !== null) {
					$url .= "&username=" . Adminer\url_escape($username);
					$loggedIn = true;
					break;
				}
			}
			$selected = ($driver == Adminer\DRIVER && (string) $name === Adminer\SERVER);
			echo "<option value='" . Adminer\h($url) . "'" . ($selected ? " selected" : "")
				. " title='" . ($loggedIn ? "Přihlášeno" : "Vyžaduje přihlášení") . "'>"
				. Adminer\h($name) . "</option>\n";
		}
		echo "</select></div>\n";

		echo Adminer\script("document.addEventListener('DOMContentLoaded', function () {
	var box = document.getElementById('serverselect');
	var h1 = document.querySelector('#menu > h1');
	var anchor = document.getElementById('navicons') || h1;
	if (box && anchor) anchor.after(box);
	document.getElementById('serverselect-select').addEventListener('change', function () {
		location.href = this.value;
	});
});");
		return null;
	}

	/** Seznam serveru z nakonfigurovaneho pluginu AdminerLoginServers */
	private function loginServers() {
		$adminer = Adminer\adminer();
		if (!isset($adminer->plugins) || !class_exists('AdminerLoginServers')) {
			return array();
		}
		foreach ($adminer->plugins as $plugin) {
			if ($plugin instanceof AdminerLoginServers) {
				return (function () {
					return $this->servers;
				})->call($plugin);
			}
		}
		return array();
	}

	protected $translations = array(
		'cs' => array('' => 'Výběr „Aktuální server“ v levém panelu jako v phpMyAdmin'),
	);
}
