<?php
// src/Controller/UsersController.php

namespace App\Controller;

class EmployeesController extends AppController {

	public function initialize() {
        parent::initialize();

        $this->loadComponent('Flash'); // Include the FlashComponent
    }

	public function index() {
        $this->loadComponent('Paginator');
        $this->paginate = [ // here we have define limit of the record on the page
          'limit' => '3'
        ];
        $employee = $this->paginate($this->Employees->find());
        if ($this->request->is('post')) {
            $requestData=$this->request->getData();
            $name=$requestData['searchName'];
            if($name!=""){
                $employeeArr = $this->Employees->find("all")->where(['employee_name LIKE '=>"%$name%"]);
                // $employee=$this->Paginator->paginate($employeeArr, array('page' => 0));
                $employee=$employeeArr;
            }
        }
        $this->set(compact('employee'));
    }

    public function view($EmployeeId = null) {
        $employee = $this->Employees->findByEmployeeId($EmployeeId)->firstOrFail();
        $this->set(compact('employee'));
    }

    public function add() {
        $employee = $this->Employees->newEntity();
        if ($this->request->is('post')) {
            $employee = $this->Employees->patchEntity($employee, $this->request->getData());
            if(empty($employee->upload)){
                $this->Flash->error(__('Image should not be null'));
            }else{
                $employee->employee_image=$this->uploadImg($employee->upload);
                $employee->created=date("Y-m-d")." 00:00:00";
                if ($this->Employees->save($employee) && $employee->employee_image!='') {
                    $this->Flash->success(__('Your employee has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                if($employee->employee_image==''){
                    $this->Flash->error(__('Image should be (jpg/png)'));
                }else{
                    $this->Flash->error(__('Unable to add employee.'));
                }
            }
        }
        $this->set('employee', $employee);
    }

    public function uploadImg($file){
        $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
        $fileExt=explode(".", $file['name']);
        $fileName=time().".".end($fileExt);
        if(in_array(end($fileExt), $arr_ext)){
            $imagePath=$this->request->webroot."webroot/img/".$fileName;
            move_uploaded_file($file['tmp_name'], WWW_ROOT.'img'.DS.$fileName);
            return $imagePath;
        }else{
            return "";
        }
    }

    public function edit($EmployeeId = null) {
        $employee = $this->Employees->findByEmployeeId($EmployeeId)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Employees->patchEntity($employee, $this->request->getData());
            $imageValidation=true;
            $fileVal=$employee->upload;
            if(!empty($fileVal['tmp_name'])){
                $employee->employee_image=$this->uploadImg($employee->upload);
                if($employee->employee_image==""){
                    $imageValidation=false;
                }
            }
            if ($this->Employees->save($employee) && $imageValidation) {
                $this->Flash->success(__('Employee has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            if(!$imageValidation){
                $this->Flash->error(__('Image should be (jpg/png)'));
            }else{
                $this->Flash->error(__('Unable to update employee.'));
            }
        }

        $this->set('employee', $employee);
    }

    public function delete($EmployeeId) {
        // $this->request->allowMethod(['post', 'delete']);

        $employee = $this->Employees->findByEmployeeId($EmployeeId)->firstOrFail();
        if ($this->Employees->delete($employee)) {
            $this->Flash->success(__('The {0} employee has been deleted.', $employee->employee_name));
            return $this->redirect(['action' => 'index']);
        }
    }
}