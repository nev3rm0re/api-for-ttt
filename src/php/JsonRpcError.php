<?php
namespace Egoh;

class JsonRpcError
{
    protected $error;
    public function __construct($request_id, $error = null)
    {
        $this->request_id = $request_id;
        $this->error = $error;
    }

    public function toJson()
    {
        return [
            'jsonrpc' => "2.0",
            'error' => $this->error,
            'id' => $this->request_id
        ];
    }
}