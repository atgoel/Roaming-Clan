<?php
//if uninstall not called from WordPress exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

require dirname( __FILE__ ) . '/classes/ATDTP_Storage_Installer.php';

$installer = new ATDTP_Storage_Installer();

$installer->do_uninstall();
