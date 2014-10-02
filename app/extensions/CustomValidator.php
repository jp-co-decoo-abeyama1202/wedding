<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomValidator
 *
 * @author admin-97
 */
class CustomValidator extends \Illuminate\Validation\Validator
{
    public function validateMbMax($attribute,$value,$parameters)
    {
        $this->requireParameterCount(1, $parameters, 'mb_max');
        $len = mb_strlen($value);
        return $len <= $parameters[0];
    }
    
    public function validateMbMin($attribute,$value,$parameters)
    {
        $this->requireParameterCount(1, $parameters, 'mb_min');
        $len = mb_strlen($value);
        return $len >= $parameters[0];
    }
    
    public function validateMbDigitsBetween($attribute, $value, $parameters)
    {
        $this->requireParameterCount(2, $parameters, 'mb_digits_between');
        $len = mb_strlen($value);
        return $len >= $parameters[0] && $len <= $parameters[1];
    }
}
