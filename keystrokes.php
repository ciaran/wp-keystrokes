<?php
/*
Plugin Name: Keystrokes
Description: Adds tooltips to keystrokes in the post content
Author: Ciarán Walsh
Author URI: http://ciaranwal.sh
*/

function add_keystroke_tooltip($matches) {
	$keystroke = $matches[0];
	$tooltip = strtr($keystroke,
		array(
			'⌥' => 'Option-',
			'⌃' => 'Control-',
			'⇧' => 'Shift-',
			'⌘' => 'Command-',

			'␣' => 'Space',
			'↩' => 'Return',
			'⌅' => 'Enter',
			'⇥' => 'Tab',
			'⇤' => 'Backtab',
			'⌫' => 'Delete',
			'⌦' => 'Forward Delete',
			'⇪' => 'Caps Lock',
			'←' => 'Left',
			'→' => 'Right',
			'↑' => 'Up',
			'↓' => 'Down',
			'↖' => 'Home',
			'↘' => 'End',
			'⇞' => 'Page Up',
			'⇟' => 'Page Down',
			'⎋' => 'Escape',
			'⏏' => 'Eject',

			// These protect the entities from being converted by the semicolon below
			// (since tr will not modify the same text twice)
			'&amp;' => '&amp;',
			'&lt;' => '&lt;',
			'&gt;' => '&gt;',
			'"' => 'Double quote',
			'\'' => 'Single quote',

			':' => 'Colon',
			'+' => 'Plus',
			'-' => 'Minus',
			';' => 'Semi-colon',
			'.' => 'Period',
			',' => 'Comma',
			)
		);
	if (substr($tooltip, -1) == '-')
		$tooltip = substr($tooltip, 0, strlen($tooltip) - 1);

	return "<abbr title=\"$tooltip\">$keystroke</abbr>";
}

function add_keystroke_tooltips($text) {
	return preg_replace_callback('/
					[⌃⌥⇧⌘]* [␣↩⌅⇥⇤⌫⌦⇪⇞⇟⎋⏏]
				|   [⌃⌥⇧⌘]+
				(
					\w\b
					| &(lt|gt|amp);
					| [^&\w\s<](?=$|\W)
				)?/xu', 'add_keystroke_tooltip', $text);
}

add_filter('the_content',     'add_keystroke_tooltips');
add_filter('get_the_excerpt', 'add_keystroke_tooltips');
add_filter('the_excerpt',     'add_keystroke_tooltips');
add_filter('the_excerpt',     'add_keystroke_tooltips');
add_filter('comment_text',    'add_keystroke_tooltips');
?>