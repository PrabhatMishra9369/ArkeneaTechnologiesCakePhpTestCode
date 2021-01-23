<?php
// src/Model/Table/EmployeesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class EmployeesTable extends Table {
    public function initialize(array $config) {

    }

    public function validationDefault(Validator $validator) {
    	$yourRegexp="^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$";
        $validator
            ->allowEmptyString('employee_name', false)
            ->minLength('employee_name', 3)
            ->maxLength('employee_name', 200)

            ->allowEmptyString('address', false)
            ->minLength('address', 3)
            ->maxLength('address', 500)

            ->allowEmptyString('phone', false)
            ->minLength('phone', 10)
            ->maxLength('phone', 15);

        $validator
            ->requirePresence('email_address','create')
            ->notBlank('email_address', 'An email is required')
            ->add('email_address', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Email is already used'
            ]);

        $validator
            ->requirePresence('phone','create')
            ->notBlank('phone', 'Phone no is required')
            ->add('phone', 'numeric', [
                'rule' => 'numeric',
                'message' => 'Numbers only used'
            ]);

        return $validator;
    }
}