<?php

define('PROJECT_ROOT_DIR', realpath(__DIR__.'/..'));
define('IMG_FULL_ROOT_DIR', PROJECT_ROOT_DIR.'/img/');
define('IMG_ROOT_DIR', '/'.basename(PROJECT_ROOT_DIR).'/img/');
define('SRC_FULL_ROOT_DIR', PROJECT_ROOT_DIR.'/src/');
define('SRC_ROOT_DIR', '/'.basename(PROJECT_ROOT_DIR).'/src/');

//Converters
define('HTML_CONVERTER_MAIN_TAG_KEY', 'tags'); //String MAIN_TAG_KEY : An option key name for the list of HTML tags to use.
define('HTML_CONVERTER_MAIN_ICON_KEY', 'icon'); //String MAIN_ICON_KEY : An option key name for the icon tag to use.
define('HTML_CONVERTER_TAG_KEY', 'tag'); //String TAG_KEY : An option key name for the HTML tag to use.
define('HTML_CONVERTER_ATTRIBUTES_KEY', 'attributes'); //String ATTRIBUTES_KEY : An option key name for the HTML attributes to use on the tag.