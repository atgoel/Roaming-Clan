<?php
/**
* Returns word count of the sentences.
*
* @since @since expedition 0.0.2
*/
if ( ! function_exists( 'expedition_words_count' ) ) :
	function expedition_words_count( $length = 25, $expedition_content = null ) {
		$length = absint( $length );
		$source_content = preg_replace( '`\[[^\]]*\]`', '', $expedition_content );
		$trimmed_content = wp_trim_words( $source_content, $length, '...' );
		return $trimmed_content;
	}
endif;