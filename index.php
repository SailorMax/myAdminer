<?php
if (file_exists("ip_filter.php"))
{
	// user defined script with possibility to filter by IP
    include_once "ip_filter.php";
}

define("CURRENT_DIR", __DIR__."/");
if (file_exists("adminer.php"))
{
	define("ADMINER_WEB_PATH", "");
	define("ADMINER_DIR", "");
}
else
{
	define("ADMINER_WEB_PATH", "adminer/");
	define("ADMINER_DIR", CURRENT_DIR.ADMINER_WEB_PATH);
}

function adminer_object()
{
    // autoloader
    foreach (glob(CURRENT_DIR."plugins/*.php") as $filename) {
        include_once $filename;
    }

    $plugins = array(
        // specify enabled plugins here
        new AdminerFileUpload((str_repeat("../", substr_count(ADMINER_WEB_PATH, "/")))."data/"),
        new AdminerSlugify(),
        new AdminerForeignSystem(),
    );

	$_php_my_admin_plugins = array();
	include_once (CURRENT_DIR."plugins/ux/_php_my_admin_plugins.php");
	$plugins += $_php_my_admin_plugins;

	// my
	class MyAdminerModifies
	{
		function head()
		{
?>
			<link rel="shortcut icon" type="image/x-icon" href="<?=ADMINER_WEB_PATH?>static/favicon.ico">
			<link rel="apple-touch-icon" href="<?=ADMINER_WEB_PATH?>static/favicon.ico">

			<link rel="stylesheet" type="text/css" href="<?=ADMINER_WEB_PATH?>static/default.css" />

<?php if (file_exists(CURRENT_DIR."adminer.css")) { ?>
			<link rel="stylesheet" type="text/css" href="adminer.css" />
<?php } else if (file_exists(CURRENT_DIR."designs/nette-mod/adminer.css")) { /* default skin */ ?>
			<link rel="stylesheet" type="text/css" href="designs/nette-mod/adminer.css" />
<?php } ?>

			<script type="text/javascript" src="<?=ADMINER_WEB_PATH?>static/functions.js"<?=Adminer\nonce()?>></script>
			<script type="text/javascript" src="<?=ADMINER_WEB_PATH?>static/editing.js"<?=Adminer\nonce()?>></script>
			<script<?=Adminer\nonce()?>>
			// store as separate function for possibility to use it in js-plugins
			function adminerFixResourcesRelatedPath()
			{
				var inputs = document.getElementsByTagName("INPUT");
				var i, cnt = inputs.length;
				for (i=0; i<cnt; i++)
					if ((inputs[i].type == "image") && (inputs[i].getAttribute("src").indexOf("../") === 0))
					{
						inputs[i].src = inputs[i].getAttribute("src").replace("../adminer/", "<?=ADMINER_WEB_PATH?>");
					}
			}

			document.addEventListener("DOMContentLoaded", function(event)
			{
				adminerFixResourcesRelatedPath();
			});
			</script>
<?php if (file_exists("externals/jush")) { ?>
			<link rel="stylesheet" type="text/css" href="externals/jush/jush.css" />
			<script type="text/javascript" src="externals/jush/modules/jush.js"<?=Adminer\nonce()?>></script>
			<script type="text/javascript" src="externals/jush/modules/jush-textarea.js"<?=Adminer\nonce()?>></script>
			<script type="text/javascript" src="externals/jush/modules/jush-txt.js"<?=Adminer\nonce()?>></script>
			<script type="text/javascript" src="externals/jush/modules/jush-sql.js"<?=Adminer\nonce()?>></script>
<?php } ?>
<?php
			return false;		// do not use default adminer.css + few other files
		}
	}
	$plugins[] = new MyAdminerModifies();
	//

    /* It is possible to combine customization and plugins:
    class AdminerCustomization extends AdminerPlugin {
    }
    return new AdminerCustomization($plugins);
    */

	class myAdminerWithPlugins extends Adminer\Plugins
	{
		function login($login, $password)
		{
			// using localhost allow no password access
			if ($_SERVER["HTTP_HOST"] && (gethostbyname($_SERVER["HTTP_HOST"]) == "127.0.0.1"))
				return true;

			return parent::login($login, $password);
		}
	}

	// add all custom drivers
	$basename = "../plugins/drivers";
	if (is_dir($basename)) {
		foreach (glob("$basename/*.php") as $filename) {
			include_once "./$filename";
		}
	}

	// init
    return new myAdminerWithPlugins($plugins);
}

// include original Adminer or Adminer Editor
if (ADMINER_DIR != "")
{
	chdir(ADMINER_DIR);
	include "index.php";
}
else
	include "adminer.php";
?>
