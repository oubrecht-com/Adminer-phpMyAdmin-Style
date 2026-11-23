<?php

/** Levy panel jako v phpMyAdmin: strom vsech databazi na serveru,
* u aktualni databaze se pod ni zobrazi seznam jejich tabulek.
* Nemeni Adminer samotny - jen doplni vypis do leveho panelu.
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerDatabaseTree extends Adminer\Plugin {
	function databasesPrint($missing) {
		if (Adminer\support("single_db")) {
			return null;
		}
		$databases = Adminer\adminer()->databases();
		if (!$databases) {
			return null;
		}
		if (Adminer\DB != "" && !in_array(Adminer\DB, $databases)) {
			array_unshift($databases, Adminer\DB);
		}
		$base = preg_replace('~\b(db|ns)=[^&]*&~', '', Adminer\ME);
		$normal = array();
		$system = array();
		foreach ($databases as $db) {
			if (Adminer\driver()->isSystem($db)) {
				$system[] = $db;
			} else {
				$normal[] = $db;
			}
		}

		echo "<ul id='dbtree'>\n";
		foreach (array_merge($normal, $system) as $db) {
			$class = trim(($db === Adminer\DB ? "current" : "") . (in_array($db, $system, true) ? " system" : ""));
			echo "<li" . ($class != "" ? " class='$class'" : "") . ">"
				. "<span class='dbtoggle' role='button' title='Rozbalit / sbalit'></span>"
				. "<a href='" . Adminer\h($base . "db=" . Adminer\url_escape($db)) . "' title='" . Adminer\h($db) . "'>" . Adminer\h($db) . "</a>"
				. "</li>\n";
		}
		echo "</ul>\n";

		// Strom presunout pod odkazy v panelu a tabulky aktualni databaze vlozit pod jeji polozku.
		echo Adminer\script("document.addEventListener('DOMContentLoaded', function () {
	var tree = document.getElementById('dbtree');
	if (!tree) return;
	var menu = document.getElementById('menu');
	var links = menu.querySelector(':scope > p.links');
	var dbs = document.getElementById('dbs');
	var anchor = links || (dbs && dbs.closest('form'));
	if (anchor) anchor.after(tree);
	var current = tree.querySelector('li.current');
	var key = 'adminer-dbtree-collapsed';
	function stored() { try { return sessionStorage.getItem(key); } catch (e) { return null; } }
	function store(value) { try { if (value) sessionStorage.setItem(key, value); else sessionStorage.removeItem(key); } catch (e) {} }
	if (current) {
		var tables = document.getElementById('tables') || menu.querySelector(':scope > p.message');
		if (tables) current.appendChild(tables);
		if (stored() === current.querySelector(':scope > a').title) current.classList.add('collapsed');
		current.scrollIntoView({block: 'nearest'});
	}
	tree.addEventListener('click', function (event) {
		var li = event.target.closest('#dbtree > li');
		if (!li) return;
		var link = li.querySelector(':scope > a');
		if (event.target.classList.contains('dbtoggle')) {
			if (li === current) {
				// aktualni databazi jen sbalit/rozbalit bez nacteni stranky
				var collapsed = li.classList.toggle('collapsed');
				store(collapsed ? link.title : null);
			} else {
				location.href = link.href;
			}
		} else if (event.target === link) {
			store(null); // kliknuti na nazev databaze ji vzdy rozbali
		}
	});
});");
		return null; // vychozi vypis (#dbs, vyber schematu) bezi dal, vyber DB skryva CSS
	}

	protected $translations = array(
		'cs' => array('' => 'Levý panel jako v phpMyAdmin: strom databází s tabulkami aktuální databáze'),
	);
}
