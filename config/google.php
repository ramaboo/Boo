<?php
/* SVN FILE: $Id: google.php 230 2009-04-23 15:55:02Z david@ramaboo.com $ */
/**
 * @brief Google config file.
 * 
 * Contains default values for Google Maps constants. Be sure to override \c G_API_KEY.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			http://code.google.com/apis/maps/documentation/reference.html#GGeoStatusCode
 */

/**
 * @brief Google API key.
 * 
 * @see http://code.google.com/apis/maps/signup.html
 */
if (!defined('G_API_KEY')) { define('G_API_KEY', 'YOUR_API_KEY'); }

// GGeoStatusCode for Google Maps API. 99% chance you wont have to change anything below this line.

/**
 * @brief No errors occurred; the address was successfully parsed and its geocode has been returned.
 */
if (!defined('G_GEO_SUCCESS')) { define('G_GEO_SUCCESS', 200); }

/**
 * @brief A directions request could not be successfully parsed.
 */
if (!defined('G_GEO_BAD_REQUEST')) { define('G_GEO_BAD_REQUEST', 400); }

/**
 * @brief A geocoding or directions request could not be successfully processed, yet the exact reason for the failure is not known.
 */
if (!defined('G_GEO_SERVER_ERROR')) { define('G_GEO_SERVER_ERROR', 500); }

/**
 * @brief The HTTP q parameter was either missing or had no value. For geocoding requests, this means that an empty address was specified as input. For directions requests, this means that no query was specified in the input.
 */
if (!defined('G_GEO_MISSING_QUERY')) { define('G_GEO_MISSING_QUERY', 601); }

/**
 * @brief Synonym for \c G_GEO_MISSING_QUERY.
 */
if (!defined('G_GEO_MISSING_ADDRESS')) { define('G_GEO_MISSING_ADDRESS', 601); }

/**
 * @brief No corresponding geographic location could be found for the specified address. This may be due to the fact that the address is relatively new, or it may be incorrect.
 */
if (!defined('G_GEO_UNKNOWN_ADDRESS')) { define('G_GEO_UNKNOWN_ADDRESS', 602); }

/**
 * @brief The geocode for the given address or the route for the given directions query cannot be returned due to legal or contractual reasons.
 */
if (!defined('G_GEO_UNAVAILABLE_ADDRESS')) { define('G_GEO_UNAVAILABLE_ADDRESS', 603); }

/**
 * @brief The GDirections object could not compute directions between the points mentioned in the query. This is usually because there is no route available between the two points, or because we do not have data for routing in that region.
 */
if (!defined('G_GEO_UNKNOWN_DIRECTIONS')) { define('G_GEO_UNKNOWN_DIRECTIONS', 604); }

/**
 * @brief The given key is either invalid or does not match the domain for which it was given.
 */
if (!defined('G_GEO_BAD_KEY')) { define('G_GEO_BAD_KEY', 610); }

/**
 * @brief The given key has gone over the requests limit in the 24 hour period.
 */
if (!defined('G_GEO_TOO_MANY_QUERIES')) { define('G_GEO_TOO_MANY_QUERIES', 620); }

/**
 * @brief Use Google AJAX Libraries API.
 */
if (!defined('GOOGLE_AJAX')) { define('GOOGLE_AJAX', true); }
