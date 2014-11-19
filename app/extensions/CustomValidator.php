<?php
/**
 * 日本語対応の文字数チェック
 * mb_strlenでチェックしているだけ。
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
    
    protected function replaceMbMax($message, $attribute, $rule, $parameters)
    {
        return str_replace(':max', $parameters[0], $message);
    }
    
    public function validateMbMin($attribute,$value,$parameters)
    {
        $this->requireParameterCount(1, $parameters, 'mb_min');
        $len = mb_strlen($value);
        return $len >= $parameters[0];
    }
    
    protected function replaceMbMin($message, $attribute, $rule, $parameters)
    {
        return str_replace(':min', $parameters[0], $message);
    }
    
    public function validateMbBetween($attribute, $value, $parameters)
    {
        $this->requireParameterCount(2, $parameters, 'mb_between');
        $len = mb_strlen($value);
        return $len >= $parameters[0] && $len <= $parameters[1];
    }
    
    protected function replaceMbBetween($message, $attribute, $rule, $parameters)
    {
            return str_replace(array(':min', ':max'), $parameters, $message);
    }
}
