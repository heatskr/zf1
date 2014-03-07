<?php

class Zf1_Util_String {
  static function parameterize($str) {
    $str = preg_replace_callback('/^[A-Z]/', function($matches) {
      return strtolower($matches[0]);
    }, $str);
    $str = preg_replace_callback('/[A-Z]/', function($matches) {
      return '-' . strtolower($matches[0]);
    }, $str);
    return $str;
  }

  static function underscore($str) {
    $str = preg_replace_callback('/^[A-Z]/', function($matches) {
      return strtolower($matches[0]);
    }, $str);
    $str = preg_replace_callback('/[A-Z]/', function($matches) {
      return '_' . strtolower($matches[0]);
    }, $str);
    return $str;
  }

  static function camelize($str) {
    $str = preg_replace_callback('/^[a-z]/', function($matches) {
      return strtoupper($matches[0]);
    }, $str);
    $str = preg_replace_callback('/[_-]([a-zA-Z])/', function($matches) {
      return strtoupper($matches[1]);
    }, $str);
    return $str;
  }

  static function humanize($str) {
    $str = preg_replace_callback('/^[a-z]/', function($matches) {
      return strtoupper($matches[0]);
    }, $str);
    $str = preg_replace('/_id$/', '', $str);
    $str = preg_replace('/[-_]+|\s+/', ' ', $str);
    $str = preg_replace_callback('/ ([a-z])/', function($matches) {
      return strtoupper($matches[0]);
    }, $str);
    return $str;
  }
}
