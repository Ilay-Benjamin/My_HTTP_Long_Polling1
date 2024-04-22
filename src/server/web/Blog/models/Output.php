<?php



class Output {
    private bool $isError;
    private string $data;
    private array $httpHeaders;

    public function __construct (string $data = '', array $httpHeaders = array(), bool $isError = false) {
        array_unshift($httpHeaders, 'Content-Type: application/json');
        $this->httpHeaders = $httpHeaders;
        $this->data = $data;
        $this->isError = $isError;
    }

    public function getIsError() : bool { return $this->isError; }
    public function getData() : string { return $this->data; }
    public function getHttpHeaders() : array { return $this->httpHeaders; }
    public function setIsError(bool $isError) { return $this->isError = $isError; }
    public function setData(string $data) { return $this->data = $data; }
    public function setHttpHeaders(array $httpHeaders) { return $this->httpHeaders = $httpHeaders; }
    
}

final class OutputBuilder {
    static function okOutput(string $data = '') : Output {
        return new Output($data, ['HTTP/1.1 200 OK',], false);
    }
    static function notFoundOutput(string $data = 'Not Found') : Output {
        $data = (json_encode(array('error' => $data)));
        return new Output($data, ['HTTP/1.1 404 Not Found'], true);
    }
    static function unprocessableEntityOutput(string $data = 'Method not supported') : Output {
        $data = (json_encode(array('error' => $data)));
        return new Output($data, ['HTTP/1.1 422 Unprocessable Entity'], true);
    }
    static function internalServerErrorOutput(string $data = 'Something went wrong! Please contact support.') : Output {
        $data = (json_encode(array('error' => $data)));
        return new Output($data, ['HTTP/1.1 500 Internal Server Error'], true);
    }
}