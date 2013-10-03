<?php

class View {

    private static $layout;
    private static $title;

    public function __construct() {
        ;
    }

    public static function getLayout() {
        return self::$layout;
    }

    public static function setLayout($tmpl) {
        self::$layout = $tmpl;
    }

    public static function setTitle($title) {
        self::$title = $title;
    }

    public static function getTitle() {
        return self::$title;
    }

    public static function parseToLayout($name, $value) {
        $GLOBALS[$name] = $value;
    }

}