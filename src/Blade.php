<?php namespace Cutlass;

use Philo\Blade\Blade as BladeEngine;
use Exception;

/**
 * Used to initialize the Blade templating engine
 */
class Blade
{

    /**
     * The Blade helper object which gives us access to the Blade
     * configuration and all the cool methods Blade has.
     *
     * @var BladeEngine $bladeEngine
     */
    protected $bladeEngine;

    /**
     * An array of filenames to render in order of precedence
     *
     * @var array|string
     */
    protected $filesnames;

    /**
     * An array of data to add to the view
     *
     * @var array
     */
    protected $context;


    /**
     * Initialize the class
     *
     * @param $filenames array - An array or string of filename/s to render in order of precedence
     * @param $context   array - An array of data to add to the view
     * @param $bladeEngine   BladeEngine - The Blade renderer class
     */
    public function __construct($filenames, $context = [ ], $bladeEngine)
    {

        $this->filesnames = $filenames;
        $this->context    = $context;
        $this->blade      = $bladeEngine;

    }


    /**
     * Makes and renders the view into a cached PHP file
     * then echos and returns it.
     *
     * @return mixed
     * @throws Exception
     */
    public function render()
    {

        /**
         * Add custom directives to Blade
         */
        if ( ! empty( $this->custom_directives ) && is_array($this->custom_directives)) {
            foreach ($this->custom_directives as $key => $directive) {
                $this->directive($key, $directive);
            }
        }

        /**
         * Add global view data
         */
        if ( ! empty( $this->global_view_data ) && is_array($this->global_view_data)) {
            $this->blade->view()->share($this->global_view_data);
        }

        /**
         * Add view-specific context
         */
        if ( ! empty( $this->context ) && is_array($this->context)) {
            $this->blade->view()->share($this->context);
        }

        /**
         * Render the view (if it exists)
         *
         * Check to see if it's a single filename, else check to see if
         * there's an array of filenames
         */
        $output = false;
        if (is_string($this->filesnames)) {
            if ( ! $this->blade->view()->exists($this->filesnames)) {
                throw new Exception('View ( ' . $this->filesnames . ' ) does not exist');
            }

            $output = $this->blade->view()->make($this->filesnames)->render();
        } elseif (is_array($this->filesnames)) {

            foreach ($this->filesnames as $filename) {
                if ($this->blade->view()->exists($filename)) {
                    $output = $this->blade->view()->make($filename)->render();
                    break;
                }
            }
        }
        if ($output === false) {
            throw new Exception('No valid View found');
        }

        return $output;

    }


    /**
     * Renders the wp_head function so we can input into our view
     *
     * @return string
     */
    protected function render_wp_head()
    {
        ob_start();
        wp_head();
        return ob_get_clean();
    }


    /**
     * Adds the directive to our compiler
     *
     * @param string $key
     * @param string $directive
     */
    protected function directive($key, $directive)
    {

        if (is_callable($directive)) {
            $this->blade->getCompiler()->directive($key, $directive);

            return;
        }

        $this->blade->getCompiler()->directive($key, function ($expression) use ($directive) {
            /**
             * Replace expression string with directive variable
             */
            return str_replace('{expression}', $expression, $directive);

        });

    }
}