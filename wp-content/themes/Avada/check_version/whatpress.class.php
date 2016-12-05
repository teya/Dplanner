<?php
class WhatPress
{



   /**
    * http_request function
    *
    * @param string url a string containing a url.
    *
    * @return returns the content of the provided url.
    */
   public static function http_request($url)
   {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
   }



   /**
    * information_clean function
    *
    * @param string information a string containing some information.
    *
    * @return returns the provided information cleaned.
    */
   public static function information_clean($information)
   {
      $information = trim(preg_replace("/\s*(?:\*\/|\?>).*/", "", $information));
      return $information;
   }



   /**
    * theme_css function
    *
    * @param string url a string containing a WordPress website url.
    *
    * @return returns the theme css url of the provided WordPress website url.
    */
   public static function theme_css($url)
   {
      $data = self::http_request($url);
      preg_match("/https?:\/\/([0-9a-z-.\/]+)\/wp-content\/themes\/([0-9a-z-_.]+)\/style.css/i", $data, $match);
      return (isset($match['0']) ? $match['0'] : false);
   }



   /**
    * phrase_tags function
    *
    * @param string tags a string containing tags separated by a comma.
    *
    * @return returns the tags as an array.
    */
   public static function phrase_tags($tags) {
      if ( strpos($tags, ',') == true ) {
         $new_tags = array();
         foreach(explode(',', $tags) as $tag) {
            $new_tags[] = self::information_clean($tag);
         }
         return $new_tags;
      }
      else {
         return false;
      }
   }



   /**
    * theme_information function
    *
    * @param string url a string containing a WordPress css url.
    *
    * @return returns the theme information from the provided WordPress css url.
    */
   public static function theme_information($url)
   {
      $patterns = array(
         "Name"        => "Theme Name",
         "URI"         => "Theme URI",
         "Description" => "Description",
         "Version"     => "Version",
         "Tags"        => "Tags",
         "AuthorName"  => "Author",
         "AuthorURI"   => "Author URI",
         "License"     => "License",
         "LicenseURI"  => "License URI"
      );

      $data = str_replace("\r", "\n", self::http_request($url));

      $information = array();
      foreach($patterns as $key => $pattern) {
         if ( preg_match("/^[ \t\/*#@]*" . preg_quote($pattern, "/") . ":(.*)$/mi", $data, $match) && isset($match['1']) ) {

            if ($key == 'Tags') {
               $information[$key] = self::phrase_tags($match['1']);
            }
            else {
               $information[$key] = self::information_clean($match['1']);
            }

         }
      }

      return (!empty($information) ? $information : false);
   }



   /**
    * popular_themes function
    *
    * @return returns 24 popular themes from themeforest.
    */
   public static function popular_themes()
   {
      $data   = self::http_request('http://marketplace.envato.com/api/v3/popular:themeforest.json');
      $data   = json_decode($data, true);
      if ( isset($data['popular']['items_last_three_months']) ) {
         return array_slice($data['popular']['items_last_three_months'], 0, 24);
      }
      else {
         return false;
      }
   }



}
?>