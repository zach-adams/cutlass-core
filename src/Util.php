<?php
use Cutlass\Cutlass;

if ( ! function_exists('bcrypt')) {
    /**
     * Hash the given value.
     *
     * @param  string $value
     * @param  array  $options
     *
     * @return string
     */
    function bcrypt($value, $options = [ ])
    {
        return password_hash($value, PASSWORD_DEFAULT, $options);
    }
}
if ( ! function_exists('back')) {
    /**
     * Create a new redirect response to the previous location.
     *
     * @param  int $status
     *
     * @return mixed
     */
    function back($status = 302)
    {
        wp_redirect(wp_get_referer(), $status);
        exit;
    }
}
if ( ! function_exists('app')) {

    /**
     * Gets the container instance we created in the Blade class
     *
     * @param  string $make
     * @param  array  $parameters
     *
     * @return mixed|\Illuminate\Container\Container
     */
    function app($make = null, $parameters = [ ])
    {
        $cutlass = Cutlass::get_instance();

        $container = $cutlass::$blade->view()->getContainer();

        if (is_null($make)) {
            return $container;
        }

        return $container->make($make, $parameters);
    }
}
if ( ! function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string $path
     *
     * @return string
     */
    function asset($path)
    {
        if ( ! empty( $path )) {
            $path = '/' . $path;
        }

        return get_template_directory_uri() . '/public' . $path;
    }
}
if ( ! function_exists('app_path')) {

    /**
     * app_path
     *
     * Returns full path to the current template directory
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function app_path($path = '')
    {

        if ( ! empty( $path )) {
            $path = '/' . $path;
        }

        return get_template_directory() . $path;

    }
}

if ( ! function_exists('app_url')) {

    /**
     * app_url
     *
     * Returns full url to the current template directory
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function app_url($path = '')
    {

        if ( ! empty( $path )) {
            $path = '/' . $path;
        }

        return get_template_directory_uri() . $path;

    }
}

if ( ! function_exists('app_relative_url')) {

    /**
     * app_url
     *
     * Returns full url to the current template directory
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function app_relative_url($path = '')
    {

        if ( ! empty( $path )) {
            $path = '/' . $path;
        }

        return wp_make_link_relative(get_template_directory_uri() . $path);

    }
}

if ( ! function_exists('base_path')) {

    /**
     * base_path
     *
     * Returns full path to the current WordPress directory
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function base_path($path = '')
    {

        if ( ! empty( $path )) {
            $path = '/' . $path;
        }

        return get_home_path() . $path;

    }
}

if ( ! function_exists('base_url')) {

    /**
     * base_url
     *
     * Returns full URL to the current WordPress installation
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function base_url($path = '')
    {

        return get_site_url(null, $path, null);

    }
}

if ( ! function_exists('config_path')) {

    /**
     * config_path
     *
     * Returns full path to the current WordPress directory
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function config_path($path = '')
    {

        return get_template_directory() . '/config/' . $path;

    }
}

if ( ! function_exists('database_path')) {

    /**
     * database_path
     *
     * Returns full path to the current WordPress directory
     * * There's no relevant place for this function in
     * * WordPress (unfortunately), so we're just gonna
     * * emulate app_path()
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function database_path($path = '')
    {

        if ( ! empty( $path )) {
            $path = '/' . $path;
        }

        return get_home_path() . $path;

    }
}

if ( ! function_exists('public_path')) {

    /**
     * public_path
     *
     * Returns full path to the theme's public directory
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function public_path($path = '')
    {

        return get_template_directory() . '/public/' . $path;

    }
}

if ( ! function_exists('public_url')) {

    /**
     * public_url
     *
     * Returns full url to the theme's public directory
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function public_url($path = '')
    {

        return get_bloginfo('template_directory') . '/public/' . $path;

    }
}

if ( ! function_exists('public_relative_url')) {

    /**
     * public_relative_url
     *
     * Returns relative url to the theme's public directory
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function public_relative_url($path = '')
    {

        return wp_make_link_relative(get_bloginfo('template_directory') . '/public/' . $path);

    }
}

if ( ! function_exists('storage_path')) {

    /**
     * storage_path
     *
     * Returns full path to the theme's public directory
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function storage_path($path = '')
    {

        return get_template_directory() . '/storage/' . $path;

    }
}

if ( ! function_exists('action')) {

    /**
     * action
     *
     * Generates a URL to the given path
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function action($path = '')
    {

        return get_site_url(null, $path, null);

    }
}

if ( ! function_exists('route')) {

    /**
     * route
     *
     * Generates a URL to the given path
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function route($path = '')
    {

        return get_site_url(null, $path, null);

    }
}

if ( ! function_exists('url')) {

    /**
     * url
     *
     * Generates a URL to the given path
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function url($path = '')
    {

        return get_home_url(null, $path, null);

    }
}

if ( ! function_exists('relative_url')) {

    /**
     * relative_url
     *
     * Generates a relative URL to the given path
     *
     *
     * @param   string $path
     *
     * @return  string
     */
    function relative_url($path = '')
    {

        return wp_make_link_relative(get_site_url(null, $path, null));

    }
}

if ( ! function_exists('config')) {

    /**
     * config
     *
     * Gets the value of a WP option using get_option
     *
     *
     * @param   string $key
     * @param   string $default
     *
     * @return  string
     */
    function config($key = null, $default = null)
    {

        if (empty( $key )) {
            return $default;
        }

        $value = get_option($key);

        if (empty( $value )) {
            return $default;
        }

        return $value;

    }
}

if ( ! function_exists('csrf_field')) {
    /**
     * Generate a CSRF token form field.
     *
     * @param   string $action
     * @param   string $name
     *
     * @return  string
     */
    function csrf_field($action = -1, $name = '_wpnonce')
    {
        return wp_nonce_field($action, $name);
    }
}

if ( ! function_exists('csrf_token')) {
    /**
     * Verify the CSRF token value.
     *
     * @param   string $name
     * @param   string $action
     *
     * @return  bool/int
     */
    function csrf_token($name = '_wpnonce', $action = -1)
    {

        return wp_verify_nonce($name, $action);

    }
}

if ( ! function_exists('elixir')) {
    /**
     * Get the path to a versioned Elixir file.
     *
     * @param  string $file
     *
     * @return string
     */
    function elixir($file)
    {
        static $manifest = null;

        if (is_null($manifest)) {
            $manifest = json_decode(file_get_contents(public_path() . '/build/rev-manifest.json'), true);
        }

        if (isset( $manifest[$file] )) {
            return wp_make_link_relative(get_stylesheet_directory_uri() . '/public/build/' . $manifest[$file]);
        }

        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }
}

if ( ! function_exists('view')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string $view
     * @param  array  $data
     * @param  array  $mergeData
     *
     * @return \Illuminate\View\View
     */
    function view($view = null, $data = [ ], $mergeData = [ ])
    {
        global $cutlass;

        $factory = $cutlass->blade->view();

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($view, $data, $mergeData);
    }
}