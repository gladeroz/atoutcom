<?php 

extract(shortcode_atts(array("link_style" => "play_button", "video_url" => '#', "link_text" => "", "play_button_color" => "default", "nectar_button_color" => "default"), $atts));

$extra_attrs = ($link_style == 'nectar-button') ? 'data-color-override="false"': null;
$the_link_text = ($link_style == 'nectar-button') ? $link_text : '<span><svg version="1.1"
	 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="600px" height="800px" x="0px" y="0px" viewBox="0 0 600 800" enable-background="new 0 0 600 800" xml:space="preserve"><path fill="none" d="M0-1.79v800L600,395L0-1.79z"></path> </svg></span>';
$the_color = ($link_style == 'nectar-button') ? $nectar_button_color : $play_button_color;

echo '<a href="'.$video_url.'" '.$extra_attrs.' data-color="'.strtolower($the_color).'" class="'.$link_style.' large nectar_video_lightbox" rel="prettyPhoto">'.$the_link_text .'</a>';

?>