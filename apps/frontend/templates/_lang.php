<p><?php echo link_to(sfConfig::get("app_lang_".$sf_user->getCulture()),'change_language',array("path"=>base64_encode($_SERVER['PATH_INFO']))) ?></p>
