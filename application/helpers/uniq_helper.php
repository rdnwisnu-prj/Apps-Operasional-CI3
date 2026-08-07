<?php
defined('BASEPATH') or exit('No direct script access allowed');

function generateUniqueTransactionCode($model) 
{
    $isUnique = false;
    $maxAttempts = 100;
    $attempts = 0;
    
    while (!$isUnique && $attempts < $maxAttempts) {
        $randomNumber = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $code = 'TRO-' . $randomNumber;
        $existing = $model->checkTransactionCode($code);
        if (!$existing) {
            $isUnique = true;
            return $code;
        }
        
        $attempts++;
    }
    
    return 'TRO-' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT) . substr(time(), -3);
}



function generateUniqueAssetsCode($model) 
{
    $isUnique = false;
    $maxAttempts = 100;
    $attempts = 0;
    
    while (!$isUnique && $attempts < $maxAttempts) {
        $randomNumber = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $code = 'AST-' . $randomNumber;
        $existing = $model->checkAssetsCode($code);
        if (!$existing) {
            $isUnique = true;
            return $code;
        }
        
        $attempts++;
    }
    
    return 'AST-' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT) . substr(time(), -3);
}