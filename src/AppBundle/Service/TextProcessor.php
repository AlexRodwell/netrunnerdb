<?php


namespace AppBundle\Service;

use Michelf\Markdown;

class TextProcessor
{
    /** @var \HTMLPurifier $purifier */
    private $purifier;

    /** @var Markdown $transformer */
    private $transformer;

    public function __construct($tempDir)
    {
        $config = \HTMLPurifier_Config::create(['Cache.SerializerPath' => $tempDir]);
        $this->purifier = new \HTMLPurifier($config);

        $this->transformer = new Markdown();
    }

    /**
     * Returns a substring of $string that is $max_length length max and doesn't split
     * a word or a html tag
     */
    public function truncate(string $string, int $max_length)
    {
        $response = '';
        $token = '';

        $string = preg_replace('/\s+/', ' ', $string);

        while (strlen($token . $string) > 0 && strlen($response . $token) < $max_length) {
            $response = $response . $token;
            $matches = [];

            if (preg_match('/^(<.+?>)(.*)/', $string, $matches)) {
                $token = $matches[1];
                $string = $matches[2];
            } elseif (preg_match('/^([^\s]+\s*)(.*)/', $string, $matches)) {
                $token = $matches[1];
                $string = $matches[2];
            } else {
                $token = $string;
                $string = '';
            }
        }
        if (strlen($token) > 0) {
            $response = $response . '[&hellip;]';
        }

        return $response;
    }

    /**
     * Returns the processed version of a markdown text
     */
    public function markdown(string $string)
    {
        return $this->img_responsive($this->purify($this->transform($string)));
    }

    /**
     * removes any dangerous code from a HTML string
     *
     * @param string $string
     * @return string
     */
    public function purify(string $string)
    {
        return $this->purifier->purify($string);
    }

    /**
     * turns a Markdown string into a HTML string
     *
     * @param string $string
     * @return string
     */
    public function transform(string $string)
    {
        return $this->transformer->transform($string);
    }

    /**
     * Switches src to data-src so the user preference to autoload images can take over in the browser and behave as the user intended
     *
     * @param string $string
     * @return null|string|string[]
     */
    public function img_responsive(string $string)
    {
        return preg_replace('/<img src=/', '<img data-src=', $string);
    }
}
