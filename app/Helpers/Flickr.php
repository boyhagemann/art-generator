<?php namespace App\Helpers;

class Flickr
{
    /**
     * Perform the original API call.
     *
     * @param string $method
     * @param array $options
     * @return array
     */
    public function call($method, Array $options = [])
    {
        $endpoint = 'https://api.flickr.com/services/rest/?';
        $options += [
            'api_key' => env('FLICKR_KEY'),
            'method' => $method
        ];

        $url = $endpoint . http_build_query($options);
        $response = file_get_contents($url);
        $response = preg_replace('/jsonFlickrApi\((.*)\)/', '$1', $response);
        $json = json_decode($response, true);

        return $json;
    }

    /**
     * Do a search for photos.
     *
     * @param string $q
     * @param array $options
     * @return array
     */
    public function search($q, Array $options = [])
    {
        $options += [
            'license' => '4,5,7',
            'tags' => $q,
            'content_type' => 1, // only photos
            'media' => 'photos',
            'page' => 1,
            'format' => 'json',
            'extras' => 'url_z',
        ];

        $json = $this->call('flickr.photos.search', $options);

        return $json['photos']['photo'];
    }
}