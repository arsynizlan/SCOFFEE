<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    public $status;
    public $message;


    public function __construct($code, $status, $resource = [])
    {
        parent::__construct($resource);
        $this->code = $code;
        $this->status = $status;
    }
    public function toArray($request)
    {
        return [
            'code' => $this->code,
            'status' => $this->status,
            'data' => $this->resource,
        ];
    }
}