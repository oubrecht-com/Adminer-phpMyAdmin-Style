<?php

/** Rada ikon pod logem v levem panelu jako v phpMyAdmin:
* Domu, Odhlasit, Napoveda (dokumentace Admineru), Dokumentace SQL (podle typu serveru),
* Promenne serveru (misto nastaveni, ktere Adminer nema) a Aktualizovat.
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerNavIcons extends Adminer\Plugin {
	function databasesPrint($missing) {
		$home = substr(preg_replace('~\b(db|ns)=[^&]*&~', '', Adminer\ME), 0, -1);
		$icons = array(
			array('home', 'Domů', $home, false),
			array('logout', 'Odhlásit', '', false),
			array('help', 'Nápověda k Admineru', 'https://www.adminer.org/cs/', true),
			array('docs', 'Dokumentace SQL', $this->sqlDocs(), true),
		);
		if (Adminer\support("variables")) {
			$icons[] = array('settings', 'Proměnné serveru', $home . "&variables=", false);
		}
		$icons[] = array('reload', 'Aktualizovat', '', false);

		echo "<p id='navicons'>";
		foreach ($icons as $icon) {
			list($name, $title, $url, $external) = $icon;
			echo "<a href='" . Adminer\h($url) . "' class='navicon navicon-$name' title='" . Adminer\h($title) . "'"
				. ($external ? " target='_blank' rel='noreferrer noopener'" : "")
				. "><span>" . Adminer\h($title) . "</span></a>";
		}
		echo "</p>\n";

		echo Adminer\script("document.addEventListener('DOMContentLoaded', function () {
	var icons = document.getElementById('navicons');
	var h1 = document.querySelector('#menu > h1');
	if (!icons || !h1) return;
	h1.after(icons);
	var servers = document.getElementById('serverselect');
	if (servers) icons.after(servers);
	icons.querySelector('.navicon-reload').addEventListener('click', function (event) {
		event.preventDefault();
		location.reload();
	});
	var logout = document.getElementById('logout');
	var logoutIcon = icons.querySelector('.navicon-logout');
	if (logout) {
		logoutIcon.addEventListener('click', function (event) {
			event.preventDefault();
			logout.click();
		});
	} else {
		logoutIcon.remove();
	}
});");
		return null;
	}

	/** Odkaz na dokumentaci SQL podle typu pripojeneho serveru */
	private function sqlDocs() {
		switch (Adminer\DRIVER) {
			case 'server':
				$connection = Adminer\connection();
				return ($connection && $connection->flavor == 'maria'
					? 'https://mariadb.com/kb/en/sql-statements/'
					: 'https://dev.mysql.com/doc/refman/8.0/en/sql-statements.html');
			case 'mssql':
				return 'https://learn.microsoft.com/cs-cz/sql/t-sql/language-reference';
			case 'pgsql':
				return 'https://www.postgresql.org/docs/current/sql-commands.html';
			case 'sqlite':
				return 'https://www.sqlite.org/lang.html';
			case 'oracle':
				return 'https://docs.oracle.com/en/database/oracle/oracle-database/';
		}
		return 'https://www.adminer.org/cs/';
	}

	protected $translations = array(
		'cs' => array('' => 'Řada ikon v levém panelu jako v phpMyAdmin (Domů, Odhlásit, Nápověda, Dokumentace SQL, Proměnné, Aktualizovat)'),
	);
}
