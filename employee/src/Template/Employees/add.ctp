<!-- File: src/Template/Employees/add.ctp -->

<h1>Add Employee</h1>
<?php
    echo $this->Form->create($employee, array('enctype' => 'multipart/form-data'));
    echo $this->Form->control('employee_name');
    echo $this->Form->control('address');
    echo $this->Form->control('email_address', ['type' => 'email']);
    echo $this->Form->control('phone');
    echo $this->Form->control('date_of_birth', [ 'minYear' => date('Y') - 70, 'maxYear' => date('Y') - 1 ]);
    echo $this->Form->input('upload', array('type' => 'file'));
    echo $this->Form->button(__('Save Employee'));
    echo $this->Form->end();
?>