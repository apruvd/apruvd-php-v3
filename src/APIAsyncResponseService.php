<?php

namespace Apruvd\V3;

use Apruvd\ResponseInterface;
use Apruvd\V3\Responses\TransactionCallbackResponse;
use Closure;

/**
 * Class APIAsyncResponseService
 * @package Apruvd\V3
 */
class APIAsyncResponseService{

    /**
     * @param Closure|null $callback
     * @return mixed
     */
    public function handle(Closure $callback = null){
        $data = json_decode(file_get_contents('php://input'), true);
        if(!empty($data)){
            $data = new TransactionCallbackResponse($data);

            if($callback !== null){
                return $callback($data);
            }
            else{
                return $data;
            }
        }

        return null;
    }
}