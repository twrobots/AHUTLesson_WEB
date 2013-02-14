<?php
function showMessage($title, $content) {
	echo <<<EOD
<div class="main_message">
	<div class="block_title">$title</div>
	<div class="main_message_content">$content</div>
</div>
EOD;
}