<?php
/**
 * Storage installation class.
 *
 * @author    Themedelight
 * @package   Themedelight/ATDTP
 * @version   1.1.0
 */

class ATDTP_Storage_Installer
{
	private $table_storage = 'adventure_tours_storage';

	/**
	 * Constructor.
	 */
	public function __construct() {
	}

	public function do_install() {

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $this->get_schema() );
	}

	public function do_uninstall() {
		// locked for now
		/*global $wpdb;
		$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}{$this->table_storage}" );*/
	}

	protected function get_schema() {
		global $wpdb;

		$collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty( $wpdb->charset ) ) {
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty( $wpdb->collate ) ) {
				$collate .= " COLLATE $wpdb->collate";
			}
		}

		return "
CREATE TABLE IF NOT EXISTS {$wpdb->prefix}{$this->table_storage} (
  id bigint(20) NOT NULL auto_increment PRIMARY KEY,
  key_id bigint(20) NOT NULL,
  storage_key varchar(50) NOT NULL,
  value text NULL,
  KEY storage_key_key_id (storage_key, key_id)
) $collate;";
	}
}
