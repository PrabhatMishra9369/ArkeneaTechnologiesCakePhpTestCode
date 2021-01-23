<!-- File: src/Template/Employees/view.ctp -->

<h1><?= h($employee->employee_name) ?></h1>
<p><?= h($employee->address) ?></p>
<p><?= h($employee->email_address) ?></p>
<p><?= h($employee->phone) ?></p>
<p><?= h($employee->date_of_birth) ?></p>
<img src="<?= h($employee->employee_image) ?>" alt="CakePHP" style="max-width: 300px;" />
<p><?= $this->Html->link('Edit', ['action' => 'edit', $employee->employee_id]) ?></p>