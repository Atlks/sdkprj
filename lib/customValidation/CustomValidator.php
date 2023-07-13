<?php 
namespace App\Extension\Validation;
use Illuminate\Validation\Validator;
use Illuminate\Hashing\BcryptHasher;

class CustomValidator extends Validator {
    
    /** 
     * 哈希前验证和其它字段不相同
     * 
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return bool
     */
    public function validateDifferentBeforeHash($attribute, $value, $parameters){
        $hash = new BcryptHasher;
        $this->requireParameterCount(1, $parameters, 'different_before_hash');
        $other = $parameters[0];
        // pr($value);
        // pr($this->data[$other]);
        // exit;
        // pr(isset($this->data[$other]));
        // pr($value != $this->data[$other]);
        // pr( (int)$hash->check($value, $this->data[$other]));
        // exit;
        $bChecked = ( isset($this->data[$other]) && (! $hash->check($value, $this->data[$other])) );
        // pr($bChecked);
        // pr(intval(true && false));
        // exit;
        return $bChecked;
    }

    /**
     * 自定义密码规则
     * 
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return int
     */
    public function validateCustomPassword($attribute, $value, $parameters){
        return preg_match('/^(?=.*\d+)(?=.*[a-zA-Z]+)(?!.*?([a-zA-Z0-9]{1})\1\1).{6,16}$/', $value);
    }

    /**
     * 自定义管理员密码规则
     * 
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return int
     */
    public function validateCustomAdminPassword($attribute, $value, $parameters){
        return preg_match('/^(?=.*\d+)(?=.*[a-zA-Z]+)(?!.*?([a-zA-Z0-9]{1})\1\1).{8,16}$/', $value);
    }

    /**
     * 首字符为字母
     * 
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return int
     */
    public function validateCustomFirstCharacter($attribute, $value, $parameters){
        return preg_match('/^[a-zA-Z][a-zA-Z0-9]+$/', $value);
    }

}
