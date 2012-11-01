<?php

namespace DCMS\Bundle\CoreBundle\Helper;

use Symfony\Component\HttpFoundation\Response;

class ResponseHelper
{
    public function createJsonResponse($success, $message = '', $payload = null)
    {
        $response = array(
            'success' => $success ? 'yes' : 'no',
            'message' => $message,
        );

        if ($payload) {
            $response['payload'] = $payload;
        }

        $response = new Response(
            json_encode($response, true), 
            200,
            array('Content-Type' => 'application/json')
        );

        return $response;
    }
}
