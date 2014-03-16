<?php

require_once dirname(__FILE__) . '/ObcentoTwitterRequest.class.php';
require_once dirname(__FILE__) . '/ObcentoTwitterValidateInput.class.php';


/**
 * This is the client class for the Obcento Twitter
 * For licensing and examples:
 *
 * @see https://github.com/avalanche-development/obcento
 *
 * @author dave_kz (http://www.dave.kz/)
 * @version 1.0 (2013-03-18)
 */
class ObcentoTwitter 
{

    /**
     * $result Holds the results of the twitter request
     */
    private $result;

    /**
     * $obcentoRequest Holds the request class after it is instantiated with the configs
     */
    private $obcentoRequest;

    /**
     * The constructor for this class
     *
     * @param    string    $consumer_key            from dev.twitter.com
     * @param    string    $consumer_secret         from dev.twitter.com
     * @param    string    $access_token            from dev.twitter.com
     * @param    string    $access_token_secret     from dev.twitter.com
     */
    public function __construct($consumer_key = null, $consumer_secret = null, $access_token = null, $access_token_secret = null)
    {
        // if any of the keys are not defined, try to load the config file
        if($consumer_key === null || $consumer_secret === null || $access_token === null || $access_token_secret === null)
            require_once self::get_config_filepath();

        if($consumer_key === null || $consumer_secret === null || $access_token === null || $access_token_secret === null)
            trigger_error('ObcentoTwitter OAuth credentials were not set in the constructor!');
        else
            $this->obcentoRequest = new ObcentoTwitterRequest($consumer_key, $consumer_secret, $access_token, $access_token_secret);
    }


    /**
     * For you peeps out there who like to have cool-looking code
     *
     * @param    string    $consumer_key            from dev.twitter.com
     * @param    string    $consumer_secret         from dev.twitter.com
     * @param    string    $access_token            from dev.twitter.com
     * @param    string    $access_token_secret     from dev.twitter.com
     * @return   object    new ObcentoTwitter()
     */
    public static function instance($consumer_key = null, $consumer_secret = null, $access_token = null, $access_token_secret = null)
    {
        return new ObcentoTwitter($consumer_key, $consumer_secret, $access_token, $access_token_secret);
    }

    /**
     * Static method for pulling the default config file w/ params
     *
     * @return    string    config    filepath
     */
    private static function get_config_filepath()
    {
        $path = dirname(__FILE__);
        $path = explode(DIRECTORY_SEPARATOR, $path);
        array_pop($path);
        $path = implode(DIRECTORY_SEPARATOR, $path);
        $path .= DIRECTORY_SEPARATOR;

        return "{$path}config.php";
    }

    /**
     * example status('retweet',$id,array())
     *
     * @param $method
     * @param $args
     * @return $this
     */
    public function __call($method, $args)
    {
        $twitter_function = $args[0];
        $id = $args[1];
        $parameter_array = $args[2];

        $this->process_tweet_request("{$method}/{$twitter_function}", $id, $parameter_array);

        return $this;
    }

    /**
     * @return string JSON String of the data from Twitter
     */
    public function fetchJSON()
    {
        return $this->result;
    }

    /**
     * @return string JSON String of the data from Twitter
     */
    public function __toString()
    {
        return $this->fetchJSON();
    }

    /**
     * @return array array of the data from Twitter
     */
    public function fetchArray()
    {
        return json_decode($this->result);
    }

    /**
     * simple abstracted function to process the parameters and validate
     *
     * @param    string    $method                string path that defines the twitter method
     * @param    array     $parameter_array       array of params to pass into twitter
     * @return   boolean                          boolean on whether or not a request was made
     */
    private function process_request($method, $parameter_array)
    {
        $parameter_array = $this->clean_parameter_array($parameter_array);
        
        if($this->check_parameter_array($parameter_array) === false)
            return false;
        
        $this->result = $this->obcentoRequest->execute($method, $parameter_array);
        
        return true;
    }

    /**
     * process_tweet_request
     *
     * special case abstract function with the tweet id is part of the request endpoint
     *
     * @param    string    $method                 string path that defines the main twitter method
     * @param    int        $id                    tweet id that needs to be validated
     * @return   boolean                           boolean on whether or not a request was made
     */
    private function process_tweet_request($method, $id, $parameter_array)
    {
        // @todo add id validation?
        
        return $this->process_request("{$method}/{$id}", $parameter_array);
    }

    /**
     * goes through the params and removes null (default)
     *
     * @param    array    $array    array of params, with key => null that needs to be removed
     * @return   array              clean array with no null values
     */
    private function clean_parameter_array($array)
    {
        return array_filter($array, create_function('$value', 'return $value !== null;'));
    }

    /**
     * goes through the params and validates
     *
     * @param    array    $array    array of clean params that need to be checked for validity
     * @return   bool               simple true/false if the params are valid
     */
    private function check_parameter_array($array)
    {
        return true; // yes, this is a temp
    }

    private function validateInputArray($array)
    {
        $obcentoValidateInput = new ObcentoTwitterValidateInput();
        
        //if($contributor_details !== NULL && $this->obcentoValidateInput->check_contributor_details($contributor_details))
        //if($count !== NULL && $this->obcentoValidateInput->check_count($count))
        //if($exclude_replies !== NULL && $this->obcentoValidateInput->check_exclude_replies($exclude_replies))
        //if($include_entities !== NULL && $this->obcentoValidateInput->check_include_entities($include_entities))
        //if($include_rts !== NULL && $this->obcentoValidateInput->check_include_rts($include_rts))
        //if($include_user_entities !== NULL && $this->obcentoValidateInput->check_include_user_entities($include_user_entities))
        //if($max_id !== NULL && $this->obcentoValidateInput->check_max_id($max_id))
        //if($screen_name !== NULL && $this->obcentoValidateInput->check_screen_name($screen_name))
        //if($since_id !== NULL && $this->obcentoValidateInput->check_since_id($since_id))
        //if($trim_user !== NULL && $this->obcentoValidateInput->check_trim_user($trim_user))
        //if($user_id !== NULL && $this->obcentoValidateInput->check_user_id($user_id))
        //if($count !== NULL && $this->obcentoValidateInput->check_count($count))
        
        $cleanArray = array();
        foreach($array as $key => $value)
        {
            if($value != NULL)
                $cleanArray[$key] = $value;
        }
        return $cleanArray;
    }

}