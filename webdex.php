<?php
/*
Plugin Name: WebDex
Plugin URI: http://www.webdex.ro/
Version: v1.00
Author: <a href="http://www.webdex.ro/">WebDex</a>
Description: Instaleaza-ti pluginul de Wordpress acum. Lasa utilizatorii sa caute in 27 de dictionare direct din Blog-ul sau site-ul tau!
*/

if (!class_exists("WebDexPlugin")) {

  class WebDexPlugin {

    var $adminOptionsName = "WebDexPluginAdminOptions";

    function getAdminOptions() {

      $webdexPluginAdminOptions = array(
        'width' => '',
      );
      $adminOptions = get_option($this->adminOptionsName);
      if (!empty($adminOptions)) {
        foreach ($adminOptions as $key => $option) {
          $webdexPluginAdminOptions[$key] = $option;
        }
      }
      update_option($this->adminOptionsName, $webdexPluginAdminOptions);
      return $webdexPluginAdminOptions;

    }

    function init() {

      $this->getAdminOptions();

    }

    function printAdminPage() {

      $adminOptions = $this->getAdminOptions();
      if (isset($_POST['update_WebDexPluginSettings'])) {
        if ($_POST['width_WebDexPluginSettings'] == 'auto') {
          $adminOptions['custom'] = 0;
          $adminOptions['width'] = '';
        } elseif ($_POST['width_WebDexPluginSettings'] == 'custom') {
          $adminOptions['custom'] = 1;
          $adminOptions['width'] = ceil($_POST['custom_WebDexPluginSettings']);
        } elseif ($_POST['width_WebDexPluginSettings']) {
          $adminOptions['custom'] = 0;
          $adminOptions['width'] = ceil($_POST['width_WebDexPluginSettings']);
        }
        update_option($this->adminOptionsName, $adminOptions);
?>
<div class="updated"><strong><?php _e("Setarile au fost actualizate.", "WebDexPlugin");?></strong></div>
<?php
      }
?>
<div class=wrap>
<h2>WebDex</h2>

<h3>Latime:</h3>
<p>
<label for="width_WebDexPluginSettings_auto"><input type="radio" id="width_WebDexPluginSettings_auto" name="width_WebDexPluginSettings" value="auto"
<?php if (!$adminOptions['width']) { _e('checked="checked"', "WebDexPlugin"); }?> /> Automata</label>&nbsp;&nbsp;&nbsp;&nbsp;<br />
<label for="width_WebDexPluginSettings_120"><input type="radio" id="width_WebDexPluginSettings_120" name="width_WebDexPluginSettings" value="120"
<?php if ($adminOptions['width'] == '120') { _e('checked="checked"', "WebDexPlugin"); }?>/> 120px</label><br />
<label for="width_WebDexPluginSettings_180"><input type="radio" id="width_WebDexPluginSettings_180" name="width_WebDexPluginSettings" value="180"
<?php if ($adminOptions['width'] == '180') { _e('checked="checked"', "WebDexPlugin"); }?>/> 180px</label><br />
<label for="width_WebDexPluginSettings_200"><input type="radio" id="width_WebDexPluginSettings_200" name="width_WebDexPluginSettings" value="200"
<?php if ($adminOptions['width'] == '200') { _e('checked="checked"', "WebDexPlugin"); }?>/> 200px</label><br />
<label for="width_WebDexPluginSettings_250"><input type="radio" id="width_WebDexPluginSettings_250" name="width_WebDexPluginSettings" value="250"
<?php if ($adminOptions['width'] == '250') { _e('checked="checked"', "WebDexPlugin"); }?>/> 250px</label><br />
<label for="width_WebDexPluginSettings_330"><input type="radio" id="width_WebDexPluginSettings_330" name="width_WebDexPluginSettings" value="330"
<?php if ($adminOptions['width'] == '330') { _e('checked="checked"', "WebDexPlugin"); }?>/> 330px</label><br />
<label for="width_WebDexPluginSettings_custom"><input type="radio" id="width_WebDexPluginSettings_custom" name="width_WebDexPluginSettings" value="custom"
<?php if ($adminOptions['custom']) { _e('checked="checked"', "WebDexPlugin"); }?> /> Exact:</label> <input id="custom_WebDexPluginSettings" name="custom_WebDexPluginSettings" value="<?php if ($adminOptions['custom']) { _e($adminOptions['width'], "WebDexPlugin"); } ?>" size="4" /> px
</p>

<input type="hidden" name="update_WebDexPluginSettings" value="1" />
</div>

<?php

    }

    function printWidget($args) {

      extract($args);
      echo $before_widget;
      echo $before_title;
      $adminOptions = $this->getAdminOptions();
      if ($adminOptions['width']) {
?>
<div style="height: 100px;width: <?php echo $adminOptions['width']; ?>px;">
<?php
      }
?>
<script type="text/javascript" src="http://www.webdex.ro/js/search-widget.js"></script>
<?php
       if ($adminOptions['width']) {
?>
</div>
<?php
      }
      echo $after_title;
      echo $after_widget;

    }

  }

}

if (class_exists("WebDexPlugin")) {

  $webdexWidgetPlugin = new WebDexPlugin();

}

//Actions and Filters
if (isset($webdexWidgetPlugin)) {

  add_action('activate_webdexwidget/webdexwidget.php', array(&$webdexWidgetPlugin, 'init'));
  register_sidebar_widget('WebDex', array(&$webdexWidgetPlugin, 'printWidget'));
  register_widget_control('WebDex', array(&$webdexWidgetPlugin, 'printAdminPage'));

}
