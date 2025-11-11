<?php
require_once __DIR__ . '/jwt.php';

class JWTMiddleware extends Middleware {
    public function run($request, $response) {
        $headers = getallheaders();
        $auth_header = $headers['Authorization'] ?? '';
        
        if (empty($auth_header)) {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            $auth_header = $data['token'] ?? '';
            if (!empty($auth_header)) {
                $auth_header = 'Bearer ' . $auth_header;
            }
        }

        if (empty($auth_header)) {
            return;
        }
        
        $auth_parts = explode(' ', $auth_header);
        if(count($auth_parts) != 2) {
            return;
        }
        if($auth_parts[0] != 'Bearer') {
            return;
        }
        
        $jwt = $auth_parts[1];
        $request->user = validateJWT($jwt);
    }
}