<?php

use Illuminate\Support\Facades\Log;

function replaceNumbersFunction(string $value): string {
    return preg_replace('/[^0-9]/', '', $value);
}

function formatPhone(string $phone): string {
    Log::channel('utils')->debug('Start formatPhone');
    
    return replaceNumbersFunction($phone);
}

function formatCPFCNPJ(string $cpfCnpj): string {
    Log::channel('utils')->debug('Start formatCPFCNPJ');

    return replaceNumbersFunction($cpfCnpj);
}

function formatCEP(string $cep): string {
    Log::channel('utils')->debug('Start formatCEP');

    return replaceNumbersFunction($cep);   
}