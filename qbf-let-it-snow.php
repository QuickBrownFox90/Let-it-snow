<?php

/**
 * Plugin Name: Let it snow
 * Description: Simple plugin to let it snow
 * Author: Patrick Mauersberger
 * Version: 1.0.0
 * Author URI: https://github.com/QuickBrownFox90
 *
 * @version  1.0.0
 * @package  QBF
 */

namespace QBF;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
    exit;

define( 'QBF_LET_IT_SNOW_ROOT', __DIR__ );
define( 'QBF_LET_IT_SNOW_VERSION', '1.0.0' );

require_once( 'inc/core.php' );

use QBF\Let_It_Snow\Core as Plugin;

$Let_It_Snow = new Plugin();