<?php namespace Cutlass;

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
     * Simply loads the queried object and ID
     */
    public function __construct() {

        $queried_object = get_queried_object();

        parent::__construct($queried_object);

    }


    /**
     * Returns a nice formatted title according to which page
     * we're on.
     *
     * From Root's Sage
     * https://github.com/roots/sage
     *
     * @return string
     */
    public function title()
    {

        if (is_home()) {
            if (get_option('page_for_posts', true)) {
                return get_the_title(get_option('page_for_posts', true));
            } else {
                return 'Latest Posts';
            }
        } elseif (is_archive()) {
            return get_the_archive_title();
        } elseif (is_search()) {
            return 'Search Results for ' . get_search_query();
        } elseif (is_404()) {
            return '404 - Not Found';
        } else {
            return get_the_title($this->queried_object_id);
        }

    }


}