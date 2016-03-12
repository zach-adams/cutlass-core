<?php namespace Cutlass;

use Illuminate\Support\Str;

/**
 * This is the actual Queried Object called by WordPress
 */
class Page extends Post
{

    /**
     * The object queried by WordPress
     *
     * @var mixed
     */
    public $queried_object;


    /**
     * Simply loads the queried object and sets up the construction
     */
    public function __construct() {

        /**
         * The object queried by WordPress
         *
         * @var \WP_Post $queried_object
         */
        $queried_object = get_queried_object();

        if( !is_null($queried_object) ) {

            parent::__construct($queried_object);

        }

    }


    /**
     * Returns a nice formatted title according to which page
     * we're on.
     *
     * From Root's Sage
     * https://github.com/roots/sage
     *
     * @param int    $length
     * @param string $ellipsis
     * @param bool   $echo
     *
     * @return String|void
     */
    public function title($length = 0, $ellipsis = "...", $echo = true)
    {

        $title = '';

        if (is_home()) {
            if (get_option('page_for_posts', true)) {
                $title = get_the_title(get_option('page_for_posts', true));
            } else {
                $title = 'Latest Posts';
            }
        } elseif (is_archive()) {
            $title = get_the_archive_title();
        } elseif (is_search()) {
            $title = 'Search Results for ' . get_search_query();
        } elseif (is_404()) {
            $title = '404 - Not Found';
        } else {
            $title = ( property_exists($this, 'title') ? $this->title : $this->post_title );
        }

        $title = apply_filters('the_title', $title);

        if ( $length !== 0 && is_int($length) ) {
            $title = Str::words($title, $length, $ellipsis);
        }

        if ($echo === false) {
            return $title;
        }

        echo $title;

    }


}