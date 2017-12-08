<?php
/**
 * Plugin Name:     vmpublishing/vm_wordpress_rest_post_meta_extension
 * Plugin URI:      github.com/vmpublishing/vm_wordpress_rest_post_meta_extension
 * Description:     attaches whitelisted post meta values to the wordpress rest api v2 post show call
 * Author:          Dirk Gustke
 * Text Domain:     vmpublishing/vm_wordpress_rest_post_meta_extension
 * Version:         0.1.0
 *
 * @package         vmpublishing/vm_wordpress_rest_post_meta_extension
 */

function _vwrpme_add_meta_to_post_show()
{
    static $_whitelist = ['roofline',
        '_yoast_wpseo_canonical',
        '_yoast_wpseo_title',
        '_yoast_wpseo_metadesc',
        '_yoast_wpseo_metakeywords',
        '_yoast_wpseo_meta-robots-nofollow',
        '_yoast_wpseo_meta-robots-noindex',
        '_yoast_wpseo_primary_category',
        '_yoast_wpseo_opengraph-image',
        '_yoast_wpseo_opengraph-title',
        '_yoast_wpseo_opengraph-description',
        'is_anzeige',
        'exclusive',
        'article_type',
        'article_subtitle',
        'no_ads',
        'teaser',
        '_vm_gallery_id_list',
    ];
    register_rest_field('post', 'meta', array(
        'get_callback' => function ($post) use ($_whitelist) {
            $meta_array = get_post_meta($post['id']);
            return array_filter(
                $meta_array,
                function ($value, $key) use ($_whitelist) {
                    return in_array($key, $_whitelist);
                },
                ARRAY_FILTER_USE_BOTH
            );
        },
    ));
}
add_action('rest_api_init', '_vwrpme_add_meta_to_post_show', 9);
