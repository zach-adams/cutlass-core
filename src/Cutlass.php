<?php namespace Cutlass;

use Exception;
use InvalidArgumentException;
use Philo\Blade\Blade as BladeEngine;
use Illuminate\Filesystem\Filesystem;

class Cutlass
{

    /**
     * The unique instance of the plugin.
     *
     * @var Cutlass
     */
    private static $instance;

    /**
     * Gets an instance of our plugin.
     *
     * @return Cutlass
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * Makes and renders the view into a cached PHP file
     * then echos and returns it.
     *
     * @param array $filenames - An array of views to render in order of precedence
     * @param array $context   - An array of items to add to the view
     * @param bool $echo - Whether to echo or return output
     *
     * @return string|void
     */
    public static function render($filenames, $context = [ ], $echo = true)
    {

        $filesystem = new Filesystem();

        /**
         * The directory in which you want to have your Blade template files
         * Filter: 'cutlass_views_directory' - Change the location of the default Blade views directory
         * @var string
         */
        $views_directory = apply_filters('cutlass_views_directory', app_path() . '/resources/views');

        if(!$filesystem->exists($views_directory) || !is_writeable($views_directory)) {
            echo "Views directory '". $views_directory ."' doesn't exist or isn't writeable.";
            return;
        }

        /**
         * The directory in which you want to have Blade store it's cached/compiled files
         * Filter: 'cutlass_cache_directory' - Change the location of the Blade cache
         * @var string
         */
        $cache_directory = apply_filters('cutlass_cache_directory', app_path() . '/storage/framework/views');

        if(!$filesystem->exists($cache_directory) || !is_writeable($cache_directory)) {
            echo "Cache directory '". $cache_directory ."' doesn't exist or isn't writeable.";
            return;
        }

        /**
         * Whether the Blade cache is enabled or disabled
         * Filter: 'cutlass_disable_cache' - Enable or Disable the Blade cache
         * @var bool
         */
        $disable_cache = apply_filters('cutlass_disable_cache', false);

        if ($disable_cache === true) {
            self::clear_blade_cache($cache_directory, $filesystem);
        }

        /**
         * Create the Blade Engine
         */
        $bladeEngine = new BladeEngine($views_directory, $cache_directory);

        /**
         * Our Blade Instance
         */
        $blade = new Blade($filenames, $context, $bladeEngine);

        try {
            $output = $blade->render();
        } catch(Exception $e) {
            echo $e->getMessage();
            return;
        }

        if($echo === false) {
            return $output;
        }

        echo $output;

    }


    /**
     * Checks global wp_query for posts and returns them,
     * otherwise runs get_posts on passed query
     *
     * @param array $query
     *
     * @return array
     */
    public static function get_posts($query = [ ])
    {
        global $wp_query;

        /**
         * Set return var
         */
        $posts = [ ];

        /**
         * If the query's empty and the global WP_Query has posts grab them
         * else just grab the posts the normal way
         */
        if (empty( $query ) && property_exists($wp_query, 'posts') && ! empty( $wp_query->posts )) {
            $posts = $wp_query->posts;
        } else {
            $posts = get_posts($query);
        }

        /**
         * Return empty if either of those fail
         */
        if (empty( $posts )) {
            return [ ];
        }

        /**
         * Convert WP_Posts to Posts
         */
        self::convert_posts($posts);

        /**
         * Return array of Posts
         */
        return $posts;

    }


    /**
     * Gets the post and converts it into a Cutlass Post using the get_post function
     *
     * See {@link sanitize_post()} for optional $filter values. Also, the parameter
     * $post, must be given as a variable, since it is passed by reference.
     *
     * @param int|\WP_Post|null $post   Optional. Post ID or post object. Defaults to global $post.
     *
     * @return Post|bool|null
     */
    public static function get_post( $post = null )
    {

        $post = get_post($post);

        /**
         * If it's a correct WP_Post convert it to a Cutlass Post
         */
        if ($post instanceof \WP_Post) {
            return new Post($post);
        }

        return null;

    }


    /**
     * Converts WP_Posts to Posts
     *
     * * Note: We use array_walk over foreach for memory conservation because
     * * the gained time is not worth the memory lost
     *
     * @param array|\WP_Post $posts
     *
     * @return array
     */
    public static function convert_posts(&$posts)
    {

        /**
         * If it's already Post just return
         */
        if ($posts instanceof Post) {
            return $posts;
        }

        /**
         * If it's a single WP_Post object convert it and return
         */
        if ($posts instanceof \WP_Post) {
            $posts = new Post($posts);

            return $posts;
        }

        /**
         * Convert all posts
         */
        array_walk($posts, function (&$value, $key) {
            $value = new Post($value);
        });

    }


    /**
     * Clears the entire Blade cache directory
     *
     * @param string $cache_directory
     * @param  Filesystem $filesystem
     *
     * @return array
     */
    protected static function clear_blade_cache($cache_directory, $filesystem)
    {

        return $filesystem->deleteDirectory($cache_directory);

    }
}