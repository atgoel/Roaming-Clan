<?php
/**
 * Converts content for good presentation in Visual Composer plugin.
 *
 * @author    Themedelight
 * @package   Themedelight/ATDTP
 * @version   2.0.0
 */

class ATDTP_Shortcodes_VC_Content_Normilizer
{
	public $silent_mode = false;

	public $replacement_mode_active = true;

	public $normilize_mode_active = true;

	public $tags_map = array(
		'row' => 'vc_row',
		'column' => 'vc_column',
	);

	public $attributes_map = array(
		'column' => array(
			// 'attribute_name' => 'replacement_method'
			'width' => 'replace_attribute_width_for_column',
			'css_class' => 'replace_attribute_css_class',
			'add_mobile_spacer' => 'replace_attribute_add_mobile_spacer',
		),
		'row' => array(
			'css_class' => 'replace_attribute_css_class',
		),
	);

	public $normilize_action_name = 'at_content_normilize_action';

	public $attribute_add_mobile_spacer = 'add_mobile_spacer="on"';

	public $shortcode_responsive_spacer = '[vc_empty_space height="40px" el_class="visible-sm visible-xs"]';

	private $inited = false;

	public function __construct( $config = array() ) {
		if ( $config ) {
			$this->set_config( $config );
		}
		$this->init();
	}

	public function set_config(array $config) {
		foreach ( $config as $option => $value ) {
			$this->$option = $value;
		}
	}

	public function is_active() {
		return $this->replacement_mode_active || $this->normilize_mode_active;
	}

	public function init() {
		if ( $this->inited ) {
			return false;
		}

		$this->inited = true;

		if ( $this->is_active() ) {
			// if ( is_admin() && function_exists( 'vc_manager') ) {
			add_action( 'edit_form_after_title', array( $this, 'run' ) ); 

			add_filter( 'adventure_tours_shortcodes_register_preload_list', array( $this, 'filter_preload_shortcodes_for_register'), 20 );
		}

		return true;
	}

	public function post_requires_processing( $content ) {
		$result = false;

		if ( $this->replacement_mode_active && $this->has_deprecated_shorcodes( $content ) ) {
			$result = true;
		}

		if ( ! $result && $this->normilize_mode_active && $this->normilization_required( $content ) ) {
			$result = true;
		}

		return $result;
	}

	public function run( $post ){
		if ( ! function_exists( 'vc_editor_post_types' ) || ! in_array( $post->post_type, vc_editor_post_types() ) ) {
			return;
		}

		if ( ! $this->post_requires_processing( $post->post_content ) ) {
			return;
		}

		$run_convert_action = ! empty( $_REQUEST[ $this->normilize_action_name ] );

		if ( $this->silent_mode || $run_convert_action ) {
			$new_content = $this->process( $post->post_content );
			if ( $new_content != $post->post_content ) {
				$post->post_content = $new_content;

				add_action( 'admin_print_footer_scripts', array( $this, 'render_tiny_mce_dirty_js' ) );
			}

			if ( ! $this->silent_mode ) {
				echo $this->render_notice( __( 'Post content has been converted according to Visual Composer plugin requirements.', 'adventure-tours-data-types' ) );
			}
		} else {
			$additional_arg = array();
			$additional_arg[ $this->normilize_action_name ] = 1;
			$action_url = add_query_arg( $additional_arg );

			$message_text = sprintf(
				esc_html__( 'This post content should be converted for Visual Composer. Please click %s to convert your post content.', 'adventure-tours-data-types' ),
				sprintf( '<a href="%s" title="%s" class="button button-primary" style="padding-top:2px"><i class="dashicons dashicons-controls-repeat"></i></a>',
					esc_url( $action_url ),
					esc_attr__( 'convert content', 'adventure-tours-data-types' )
				)
			);

			echo $this->render_notice( $message_text, true );
		}
	}

	public function process( $content ) {
		if ( $this->replacement_mode_active && $this->has_deprecated_shorcodes( $content ) ) {
			$content = $this->replace_shortcodes( $content );
		}

		if ( $this->normilize_mode_active && $this->normilization_required( $content ) ) {
			$content = $this->normilize_content( $content );
		}

		return $content;
	}

	public function replace_shortcodes( $content ) {
		return preg_replace_callback( $this->get_deprecated_shortcodes_regexp(), array( $this, 'replace_pattern' ), $content );
	}

	public function has_deprecated_shorcodes( $content ) {
		return preg_match( $this->get_deprecated_shortcodes_regexp(), $content );
	}

	public function get_deprecated_shortcodes_regexp() {
		$tag_names = array_keys( $this->tags_map );
		return sprintf( '`\[(?P<close_id>\/)?(?P<tag_name>%s)(?P<attributes>[^\]]*)?\]`', join('|', $tag_names ) );
	}

	public function replace_pattern( $r ) {
		$original_tag = $tag = $r['tag_name'];
		$origianl_attributes = $attributes = $r['attributes'];
		$is_add_responsive_spacer = false;

		if ( isset( $this->tags_map[ $tag ] ) ) {
			$tag = $this->tags_map[ $tag ];

			if ( 'column' == $original_tag && false !== strpos( $origianl_attributes, $this->attribute_add_mobile_spacer ) ) {
				$is_add_responsive_spacer = true;
			}

			if ( $attributes && !empty( $this->attributes_map[ $original_tag ] ) ) {
				foreach ( $this->attributes_map[ $original_tag ] as $attrib_name => $replacement_method ) {
					$attributes = preg_replace_callback(
						sprintf( '/\s(?P<attribute>%s)="(?P<value>[^"]+)"/', $attrib_name ),
						array( $this, $replacement_method ),
						$attributes
					);
				}
			}
		}

		return sprintf('[%s%s%s]%s',
			$r['close_id'],
			$tag,
			$attributes,
			$is_add_responsive_spacer ? $this->shortcode_responsive_spacer : ''
		);
	}

	public function replace_attribute_width_for_column( $matches ) {
		$original_name = $matches['attribute'];
		if ( 'width' == $original_name ) {
			$original_value = $matches['value'];
			$converted_value = null;

			$match_parts = null;
			if ( class_exists( 'ATDTP_Shortcodes_Row' ) ) {
				$converted_value = ATDTP_Shortcodes_Row::convert_width_to_class( $original_value );
			} else if ( preg_match( '`(\d+)\s*\/\s*(\d+)`', $original_value, $match_parts)) {
				if ( $match_parts[1] > 0 && $match_parts[1] > 0 ) {
					$converted_value = 'col-md-' . round( $match_parts[1] / $match_parts[2] * 12 );
				}
			}

			if ( $converted_value ) {
				return sprintf( ' offset="vc_%s"', $converted_value );
			}
		}

		return $matches[0];
	}

	public function replace_attribute_css_class( $matches ) {
		$original_name = $matches['attribute'];
		if ( 'css_class' == $original_name ) {
			return sprintf( ' el_class="%s"', $matches['value'] );
		}
		return $matches[0];
	}

	public function replace_attribute_add_mobile_spacer( $matches ) {
		$original_name = $matches['attribute'];
		if ( 'add_mobile_spacer' == $original_name ) {
			return '';
		}
		return $matches[0];
	}

	public function render_notice( $text, $is_warning = false ) {
		$classes = 'notice inline';
		if ( $is_warning ) {
			$classes .= ' notice-warning';
		} else {
			$classes .= ' notice-info';
		}
		return sprintf( '<div class="%s"><p>%s</p></div>', esc_attr( $classes ), $text );
	}

	public function render_tiny_mce_dirty_js(){
		echo <<<JS
<script> var ADTPDirtyMarker = {
	_iteration:0,
	check:function(){
		if ( typeof tinymce != 'undefined' ) {
			var editor = tinymce.get('content');
			if ( editor ) {
				this._patchEditor( editor );
			} else {
				var self = this;
				tinymce.on( 'SetupEditor', function( editor ){
					if ( 'content' == editor.id ) {
						self._patchEditor( editor );
					}
				});
			}
		} else {
			this._iteration++;
			if ( this._iteration > 20 ) {
				return;
			}
			if ( !this._cb ) {
				var self = this;
				this._cb = function(){
					self.check();
				}
			}
			setTimeout( this._cb, 300 );
		}
	},
	_patchEditor:function( editor ){
		editor.isDirty = function(){
			return true;
		};
	}
};
jQuery(function(){ ADTPDirtyMarker.check(); });
</script>
JS;
	}

	/**
	 * If replacer is active we need remove [row] shortcode from list of shortcodes available in insert shortcodes menu.
	 *
	 * @param  assoc $list
	 * @return assoc
	 */
	public function filter_preload_shortcodes_for_register( $list ) {
		if ( isset( $list['row'] ) ) {
			unset( $list['row'] );
		}
		return $list;
	}

	/** Normalization feature */

	public $trim_column_shortcode_whitspaces = true;

	public $wrap_shortcode = 'vc_column_text';

	public $wrap_html_shortcode = 'vc_raw_html';

	public $collector_shortcode = 'mmmappp_collllllecttorr';

	protected $collector_index = 0;

	protected $collector_map = array();

	protected $cache_normilize = array();

	public function normilization_required( $content ) {
		// return $content && ! preg_match('/^(\[.*\])*$/', $content);
		return $content != $this->normilize_content( $content );
	}

	public function normilize_content( $content, $allow_cache = true, $level = 0 ) {
		global $shortcode_tags;

		$cache_key = md5( $content );
		if ( $allow_cache && isset( $this->cache_normilize[ $cache_key ] ) ) {
			return $this->cache_normilize[ $cache_key ];
		}

		$collected_shortcodes = false;
		if ( false !== strpos( $content, '[' ) && ! empty( $shortcode_tags ) && is_array( $shortcode_tags ) ) {
			// Find all registered tag names in $content.
			preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );

			$parsed_tags = $matches[1];
			// as vc_* shortcodes are not registered, so ignore check for registered shortcodes
			// $tagnames = array_intersect( array_keys( $shortcode_tags ), $parsed_tags );
			$tagnames = $parsed_tags;

			if ( empty( $tagnames ) ) {
				return $content;
			}

			$content = do_shortcodes_in_html_tags( $content, true, $tagnames );

			// Replace all shortcodes with "map collector" shortcode.
			$content = $this->inject_collector_shortcodes( $content, $tagnames, $level );

			// Always restore square braces so we don't break things like <!--[if IE ]>
			$content = unescape_invalid_shortcodes( $content );

			$collected_shortcodes = true;
		}

		$content = $this->wrap_text_blocks( $content );

		if ( $collected_shortcodes ) {
			$content = $this->expand_collector_shortcodes( $content, $level < 1 );

			/*if ( $this->trim_column_shortcode_whitspaces && $level < 1 ) {
				$whitespace_escaper_rules = array(
					'`\]\s+\[vc_column`' => '][vc_column',
					'`(\[/vc_column(?:\_inner)?\])\s+(\[/vc_row(?:\_inner)?\])`' => '\1\2',
				);

				$content = preg_replace( array_keys( $whitespace_escaper_rules ), $whitespace_escaper_rules, $content );
			}*/

			if ( $this->trim_column_shortcode_whitspaces && $level < 1 ) {
				$content = preg_replace( '`\]\s*(\t?\n)+\s*\[`', '][', $content );
			}
		}

		$this->cache_normilize[ $cache_key ] = $content;

		return $content;
	}

	protected function wrap_text_blocks( $content, $skip_empty_text_blocks = true ) {
		$lines = explode( "\n", $content);
		$converted_lines = array();
		$opened = false;
		$current_text_parts = array();
		foreach ( $lines as $line ) {
			$is_shortcodes_line = $line && false !== strpos( $line, '[' ) && preg_match( '/^\s*(\[' . $this->collector_shortcode . ' id="\d+"\]\s*)+$/', $line );

			$need_open = !$is_shortcodes_line && !$opened;
			if ( $need_open || ( $is_shortcodes_line && $opened ) ) {
				if ( $need_open ) {
					$current_text_parts = array( $line );
				} else {
					$converted_lines[] = $this->make_text_block( $current_text_parts, $skip_empty_text_blocks );
					$converted_lines[] = $line;
				}
				$opened = !$opened;
			} elseif ( $opened ) {
				$current_text_parts[] = $line;
			} else {
				$converted_lines[] = $line;
			}
		}

		if ( $opened ) {
			$converted_lines[] = $this->make_text_block( $current_text_parts, $skip_empty_text_blocks );
			$opened = !$opened;
		}

		return join( "\n", $converted_lines );
	}

	protected function make_text_block( $text, $skip_empty_blocks = true ) {
		if ( is_array( $text ) ) {
			$text = join( "\n", $text );
		}

		if ( $skip_empty_blocks && preg_match('`^\s*$`', $text ) ) {
			return $text;
		}

		$has_tags = wp_strip_all_tags( $text ) != trim( $text );
		if ( $has_tags ) {
			$balanced_tags = force_balance_tags( $text );
			if ( $balanced_tags != $text ) {
				$text = sprintf( "<!-- invalid HTML block -->\n<!-- \n%s\n-->", $text );
			}
		}

		if ( $has_tags ) {
			return $this->get_wrap_shorcode( true, true ) . base64_encode( $this->expand_collector_shortcodes( $text, false ) ) . $this->get_wrap_shorcode( false, true );
		} else {
			return $this->get_wrap_shorcode( true ) . $text . $this->get_wrap_shorcode( false );
		}
	}

	public function get_wrap_shorcode( $open = true, $html = false ) {
		$name = $html ? $this->wrap_html_shortcode : $this->wrap_shortcode;
		return sprintf('[%s%s]', $open ? '' : '/', $name );
	}

	protected function generate_collector_shortcode_text( $id ) {
		return sprintf('[%s id="%s"]', $this->collector_shortcode, $id );
	}

	protected function inject_collector_shortcodes( $content, $tagnames, $level = 0 ) {
		if ( $level < 1 ) {
			$this->reset_collector_state();
		}
		if ( $tagnames ) {
			$dummy_shortcodes = array();

			// WP before 4.4.2 does not support $tagnames parameter for get_shortcode_regex function, so we need register all missed shortcodes
			// to be sure that will have regexp for them
			$wp_version = isset( $GLOBALS['wp_version'] ) ? $GLOBALS['wp_version'] : '4.4.2';
			if ( version_compare( $wp_version, '4.4.2', '<' ) ) {
				foreach ( $tagnames as $tag_name ) {
					if ( ! shortcode_exists( $tag_name ) ) {
						$dummy_shortcodes[] = $tag_name;
						add_shortcode( $tag_name, '__return_empty_string' );
					}
				}
			}

			$shorcodes_pattern = get_shortcode_regex( $tagnames );

			if ( $dummy_shortcodes ) {
				foreach ( $dummy_shortcodes as $tag_name ) {
					remove_shortcode( $tag_name );
				}
			}

			return preg_replace_callback( "/$shorcodes_pattern/", array( $this, '_register_collector_shortcode_text' ), $content );
		}
		return $content;
	}

	public function _register_collector_shortcode_text( $m ) {
		$this->collector_index++;

		$new_id = $this->collector_index;

		$sc_name = isset( $m[2] ) ? $m[2] : '';
		$full_text = $m[0];
		$additional_normilize_required = array( 'vc_row', 'vc_column', 'vc_row_inner', 'vc_column_inner' );
		if ( in_array( $sc_name, $additional_normilize_required ) ) {
			$sc_content = $m[5];
			$processed_content = $this->normilize_content( $sc_content, true, 1 );
			if ( $sc_content != $processed_content ) {
				$full_text = str_replace( $sc_content, $processed_content, $full_text );
			}
		}
		$this->collector_map[ $new_id ] = $full_text;

		return $this->generate_collector_shortcode_text( $new_id );
	}

	protected function expand_collector_shortcodes( $content, $reset_collector_state = true ) {
		if ( ! $this->is_empty_collector() ) {
			// Returning back origianl shortcodes instead of "map collector" shortcode [start]

			$replacements_map = array();
			foreach ($this->collector_map as $rep_id => $text ) {
				$replacements_map[ $this->generate_collector_shortcode_text( $rep_id ) ] = $text;
			}
			if ( $replacements_map ) {
				$content = str_replace( array_keys( $replacements_map ), $replacements_map, $content );
			}

			if ( $reset_collector_state ) {
				$this->reset_collector_state();
			}
		}
		return $content;
	}

	protected function is_empty_collector() {
		return empty( $this->collector_map );
	}

	protected function reset_collector_state() {
		if ( ! $this->is_empty_collector() ) {
			$this->collector_index = 0;
			$this->collector_map = array();
		}
	}
}
