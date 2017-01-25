<?php

class PluginRatConfig extends CommonDBTM {

   static protected $notable = true;
   
   /**
    * @see CommonGLPI::getMenuName()
   **/
   static function getMenuName() {
      return __('Rat');
   }
   
   static function getMenuContent() {
   	global $CFG_GLPI;
   
   	$menu = array();

      $menu['title']   = __('Rat','rat');
      $menu['page']    = "/plugins/rat/front/rat.php";
   	return $menu;
   }
}

function plugin_init_rat() {
  
   global $PLUGIN_HOOKS, $LANG ;
       
    $PLUGIN_HOOKS['csrf_compliant']['rat'] = true;   
    $PLUGIN_HOOKS["menu_toadd"]['rat'] = array('plugins'  => 'PluginRatConfig');
    $PLUGIN_HOOKS['config_page']['rat'] = "front/index.php"; 
                
}


function plugin_version_rat(){
	global $DB, $LANG;

	return array('name'			=> __('Rat','rat'),
					'version' 			=> '0.0.1',
					'author'			   => '<a href="pabloregeir@gmail.com"> Pablo Rieger </b> </a>',
					'license'		 	=> 'GPLv2+',
					'homepage'			=> 'http://glpi-os.sourceforge.net',
					'minGlpiVersion'	=> '0.85'
					);
}

function plugin_rat_check_prerequisites(){
        if (GLPI_VERSION>=0.85){
                return true;
        } else {
                echo "GLPI version NOT compatible. Requires GLPI 0.85";
        }
}


function plugin_rat_check_config($verbose=false){
	if ($verbose) {
		echo 'Installed / not configured';
	}
	return true;
}
?>
