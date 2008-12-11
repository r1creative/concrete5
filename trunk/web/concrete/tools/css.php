<?
header("Content-Type: text/css");
$co = Request::get();
$v = View::getInstance();
$au = $co->getAuxiliaryData();
if (isset($au->theme) && isset($au->file)) {
	$pt = PageTheme::getByHandle($au->theme);
	if ($_REQUEST['mode'] == 'preview') {
	 	$val = Cache::get('preview_theme_style', $pt->getThemeID());
		if (is_array($val)) {
			$values = $pt->mergeStylesFromPost($val);
			$pt->outputStyleSheet($au->file, $values);
			exit;
		}
	}
	
	$style = Cache::get($au->theme, $au->file);
	if ($style == '') {
		$style = $pt->parseStyleSheet($au->file);
		Cache::set($au->theme, $au->file, $style, 10800);
	}

	print $style;

}