<?php

namespace Roguetheory\SquareAPI;

class SquareAPI {

    /**
     * @var string
     */
    protected string $base_url = '';

    /**
     * @var string
     */
    protected string $version = '';

    /**
     * @var string
     */
    protected string $authorization = '';

    /**
     * @var string
     */
    protected string $type = '';

    /**
     * @var array
     */
    protected array $headers = [];

    /**
     * SquareAPI constructor.
     * @param string|null $base_url
     * @param string|null $version
     * @param string|null $authorization
     * @param string $type
     */
    public function __construct( string $base_url = null, string $version = null, string  $authorization = null,  string  $type = 'application/json' ) {
        if( $base_url ) {
            $this->base_url = $base_url;
        }
        if( $version ) {
            $this->version = $version;
        }
        if( $authorization ) {
            $this->authorization = $authorization;
        }
        $this->type = $type;
        $this->setHeaders();
    }
    
    /**
     * Set the headers
     * @return void
     */
    protected function setHeaders() : void {
        if( ! empty( $this->version ) ) {
            $this->headers[] = 'Square-Version: ' . $this->version;
        }
        if( ! empty( $this->authorization ) ) {
            $this->headers[] = 'Authorization: Bearer ' . $this->authorization;
        }
        if( ! empty( $this->type ) ) {
            $this->headers[] = 'Content-Type: ' . $this->type;
        }
    }

    /**
     * @param $endpoint
     * @return string
     */
    protected function getCurloptUrl( $endpoint ) : string {
        return $this->base_url . '/' . $endpoint;
    }

    /**
     * @param string $endpoint
     * @return bool|string
     */
    public function get( string $endpoint ) : bool|string {
        $ch = curl_init();
        $headers = $this->headers;
        curl_setopt( $ch, CURLOPT_URL, $this->getCurloptUrl( $endpoint ) );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        $response = curl_exec( $ch );
        curl_close($ch);
        return $response;
    }

    /**
     * @param string $endpoint
     * @param array $body
     * @return bool|string
     */
    public function post( string $endpoint, array $body ) : bool|string {
        $headers = $this->headers;
        $headers[] = 'Content-Type: ' . $this->type;
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $this->getCurloptUrl( $endpoint ) );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $body ) );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        $response = curl_exec( $ch );
        curl_close($ch);
        return $response;
    }
}

