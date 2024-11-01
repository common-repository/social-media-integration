<?php

/**
 * Created by PhpStorm.
 * User: DeveloperH
 * Date: 1/27/16
 * Time: 12:48 AM.
 */
if (!class_exists('View')) {

    /**
     * Class View.
     */
    class View
    {
        /**
         * View constructor.
         */
        public function __construct()
        {
        }

        /**
         * @param string $views
         * @param array  $array
         */
        public function load($views = '', $array = array())
        {
            $view=$this;

            if (!empty($views)) {
                $views = PLUGIN_DIR . "views/{$views}.php";
                if (file_exists($views)) {
                    if (is_array($array) != 0) {
                        extract($array);
                    }
                    include_once $views;
                }
            }
        }

        /**
         * @param array $a
         *
         * @return bool
         */
        private function _isMultiArray($a)
        {
            foreach ($a as $v) {
                if (is_array($v)) {
                    return true;
                }
            }

            return false;
        }
    }
}
$view = new View();