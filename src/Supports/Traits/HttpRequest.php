<?php

namespace tools\Supports\Traits;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

trait HttpRequest
{
    /**
     * GET
     *
     * @author liyong <458878932@qq.com>
     *
     * @param string $endpoint
     * @param array  $query
     * @param array  $headers
     *
     * @return array|string
     */
    protected function get($endpoint, $query = [], $headers = [])
    {
        return $this->request('get', $endpoint, [
            'headers' => $headers,
            'query'   => $query,
        ]);
    }

    /**
     * POST
     *
     * @author liyong <458878932@qq.com>
     *
     * @param string       $endpoint
     * @param string|array $data
     * @param array        $options
     *
     * @return array|string
     */
    protected function post($endpoint, $data, $options = [])
    {
        if (!is_array($data)) {
            $options['body'] = $data;
        } else {
            $options['form_params'] = $data;
        }

        return $this->request('post', $endpoint, $options);
    }

    /**
     * send request
     *
     * @author liyong <458878932@qq.com>
     *
     * @param string $method
     * @param string $endpoint
     * @param array  $options
     *
     * @return array|string
     */
    protected function request($method, $endpoint, $options = [])
    {
        return $this->unwrapResponse($this->getHttpClient($this->getBaseOptions())->{$method}($endpoint, $options));
    }

    /**
     * Get base options
     *
     * @author liyong <458878932@qq.com>
     *
     * @return array
     */
    protected function getBaseOptions()
    {
        $options = [
            'base_uri'         => property_exists($this, 'base_uri') ? $this->base_uri : '',
            'timeout'          => property_exists($this, 'timeout') ? $this->timeout : 5.0,
            'connect_timeout'  => property_exists($this, 'connect_timeout') ? $this->connect_timeout : 5.0,
        ];

        return $options;
    }

    /**
     * Return http client
     *
     * @param array $options
     *
     * @return \GuzzleHttp\Client
     */
    protected function getHttpClient(array $options = [])
    {
        return new Client($options);
    }

    /**
     * Convert response
     *
     * @author liyong <458878932@qq.com>
     *
     * @param ResponseInterface $response
     *
     * @return array|string
     */
    protected function unwrapResponse(ResponseInterface $response)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        $contents = $response->getBody()->getContents();

        if (false !== stripos($contentType, 'json') || stripos($contentType, 'javascript')) {
            return json_decode($contents, true);
        } elseif (false !== stripos($contentType, 'xml')) {
            return json_decode(json_encode(simplexml_load_string($contents, 'SimpleXMLElement', LIBXML_NOCDATA), JSON_UNESCAPED_UNICODE), true);
        }

        return $contents;
    }
}
