<?php

class XSSChecker {
    private $ml_service_url = 'http://localhost:5001/analyze';
    
    public function checkInput($input) {
        $data = json_encode(['input' => $input]);
        
        $ch = curl_init($this->ml_service_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            curl_close($ch);
            throw new Exception('Error checking input: ' . curl_error($ch));
        }
        
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception('ML service returned error: ' . $result);
        }
        
        $response = json_decode($result, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid response from ML service');
        }
        
        return $response;
    }
}

// Function to sanitize and validate form inputs
function validateInput($input) {
    if (empty($input)) {
        return ['error' => 'Input cannot be empty'];
    }
    
    $xssChecker = new XSSChecker();
    try {
        $result = $xssChecker->checkInput($input);
        return $result;
    } catch (Exception $e) {
        error_log('XSS Checker Error: ' . $e->getMessage());
        return ['error' => $e->getMessage()];
    }
}
?>
