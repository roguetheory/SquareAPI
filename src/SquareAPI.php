<?php

namespace roguetheory\SquareAPI;

class SquareAPI {

    protected string $base_url = '';
    protected string $version = '';
    protected string $authorization = '';
    protected string $type = '';
    protected array $headers = [];

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

    public function get( string $endpoint ) {
        $ch = curl_init();
        $headers = $this->headers;
        curl_setopt( $ch, CURLOPT_URL, $this->getCurloptUrl( $endpoint ) );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        $response = curl_exec( $ch );
        curl_close($ch);
        return $response;
    }

    public function post( string $endpoint, array $body ) {
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

    protected function getCurloptUrl( $endpoint ) {
        return $this->base_url . '/' . $endpoint;
    }

    protected function setHeaders() {
        if( ! empty( $this->version ) ) {
            $this->headers['Square-Version'] = $this->version;
        }
        if( ! empty( $this->authorization ) ) {
            $this->headers['Authorization'] = 'Bearer ' . $this->authorization;
        }
        if( ! empty( $this->type ) ) {
            $this->headers['Content-Type'] = $this->type;
        }

    }
}
?>
