<?php

class Esresso_Helper_String{


	/**
	* Replace the last occurrence of a string.
	*
	* @param string $search
	* @param string $replace
	* @param string $subject
	* @return string
	*/
	function strReplaceLast ( $search, $replace, $subject ) {
	 
	    $lenOfSearch = strlen( $search );
	    $posOfSearch = strrpos( $subject, $search );
	 
	    return substr_replace( $subject, $replace, $posOfSearch, $lenOfSearch );
	 
	}

	/**
	* Remove all characters except letters, numbers, and spaces.
	*
	* @param string $string
	* @return string
	*/
	function stripNonAlphaNumericSpaces( $string ) {
	    return preg_replace( "/[^a-z0-9 ]/i", "", $string );
	}
	
	
	/**
	* Remove all characters except letters and numbers.
	*
	* @param string $string
	* @return string
	*/
	function stripNonAlphaNumeric( $string ) {
	    return preg_replace( "/[^a-z0-9]/i", "", $string );
	}
	
	
	/**
	* Remove all characters except numbers.
	*
	* @param string $string
	* @return string
	*/
	function stripNonNumeric( $string ) {
	    return preg_replace( "/[^0-9]/", "", $string );
	}
	
	/**
	* Remove all characters except letters.
	*
	* @param string $string
	* @return string
	*/
	function stripNonAlpha( $string ) {
	    return preg_replace( "/[^a-z]/i", "", $string );
	}
	
	/**
	* Transform two or more spaces into just one space.
	*
	* @param string $string
	* @return string
	*/
	function stripExcessWhitespace( $string ) {
	    return preg_replace( '/  +/', ' ', $string );
	}
	
	/**
	* Format a string so it can be used for a URL slug
	*
	* @param string $string
	* @return string
	*/
	function formatForUrl( $string ) {
	 
	    $string = stripNonAlphNumericSpaces( trim( strtolower( $string ) ) );
	    return str_replace( " ", "-", stripExcessWhitespace( $string ) );
	 
	}
	
	/**
	* Format a slug into human readable string
	*
	* @param string $string
	* @return string
	*/
	function formatFromUrl( $string ) {
	    return str_replace( "-", " ", trim( strtolower( $string ) ) );
	}
	
	/**
     * Format given string to valid URL string
     *
     * @param string $url
     * @return string URL-safe string
     */
    public function formatUrl($string){
        // Allow only alphanumerics, underscores and dashes
        $string = preg_replace('/([^a-zA-Z0-9_\-]+)/', '-', strtolower($string));
        // Replace extra spaces and dashes with single dash
        $string = preg_replace('/\s+/', '-', $string);
        $string = preg_replace('|-+|', '-', $string);
        // Trim extra dashes from beginning and end
        $string = trim($string, '-');

        return $string;
    }
	
	/**
	* Get an array of unique characters used in a string. This should also work with multibyte characters.
	*
	* @param string $string
	* @return mixed
	*/
	function getUniqueChars( $string, $returnAsArray=true ) {
	    $unique = array_unique( preg_split( '/(?<!^)(?!$)/u', $string ) );
	    if ( empty( $returnAsArray ) ) {
	        $unique = implode( "", $unique );
	    }
	    return $unique;
	}
	
	/**
	* Generate a random string of specified length from a set of specified characters
	*
	* @param integer $size Default size is 30 characters.
	* @param string $chars The characters to use for randomization.
	*/
	function randomString( $size=30, $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789" ) {
	 
	    $string = "";
	    $length = strlen( $chars );
	 
	    for( $i=0; $i < $size; $i++ ) {
	        $string .= $chars{ rand( 0, $length ) };
	    }
	 
	    return $string;
	 
	}
	
	
	/**
	 * Generate random string
	 * 
	 * @param int $length Character length of returned random string
	 * @return string Random string generated
	 */
	public function randomString($length = 32)
	{
	    $string = "";
	    $possible = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789`~!@#$%^&*()-_+=";
	    for($i=0;$i < $length;$i++) {
	        $char = $possible[mt_rand(0, strlen($possible)-1)];
	        $string .= $char;
	    }
	    return $string;
	}
	
	
	/**
	 * Truncates a string to a certian length & adds a "..." to the end
	 *
	 * @param string $string
	 * @return string
	 */
	public function truncate($string, $endlength="30", $end="...")
	{
	    $strlen = strlen($string);
	    if($strlen > $endlength) {
	        $trim = $endlength-$strlen;
	        $string = substr($string, 0, $trim); 
	        $string .= $end;
	    }
	    return $string;
	}
	
}