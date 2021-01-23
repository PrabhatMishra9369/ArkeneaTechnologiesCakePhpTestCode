<!-- File: src/Template/Employees/index.ctp -->
<style>
    .ulClass{
        overflow-x: hidden;
        white-space: nowrap !important;
        height: 2em;
        width: 100%;
        float: left;
        text-align: center;
    }
    .ulClass li{
        display: inline;
        margin: 0 5px;
    }
    .ulClass li.active{
        background-color: #51d02763;
        padding: 1px 3px;
    }
    .titleDiv{
        float: left;
        width: 100%;
    }
    .titleDiv h1{
        float: left;
        width: 85%
    }
    .titleDiv .searchDiv{
        float: left;
        width: 15%;
        text-align:right;
    }
    .searchDiv .searchText{
        margin-bottom: 0px;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<div class="titleDiv">
    <h1>Employees</h1>
    <div class="searchDiv">
        <?php
            echo $this->Form->create($employee, array('class' => 'searchForm'));
            echo $this->Form->input('searchName', array('label' => array('style' => 'display:none;'), 'type' => 'text', 'placeholder' => 'Enter Employeee Name', 'class' => 'searchText'));
        ?>
        <input type="button" value="Search" class="serchBtn">
        <input type="button" value="Add" class="addBtn">
    </div>
</div>
<table>
    <tr>
        <th>Employee Name</th>
        <th>Address</th>
        <th>Email Address</th>
        <th>Phone</th>
        <th>Date of Birth</th>
        <th>Employee Image</th>
        <th>Action</th>
    </tr>

    <!-- Here is where we iterate through our $employee query object, printing out article info -->

    <?php foreach ($employee as $user): ?>
    <tr>
        <td>
            <?= $this->Html->link($user->employee_name, ['action' => 'view', $user->employee_id]) ?>
        </td>
        <td>
            <?= $user->address ?>
        </td>
        <td>
            <?= $user->email_address ?>
        </td>
        <td>
            <?= $user->phone ?>
        </td>
        <td>
            <?= $user->date_of_birth ?>
        </td>
        <td>
            <img src="<?= $user->employee_image ?>" alt="CakePHP" style="max-width: 80px;" />
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $user->employee_id]) ?>
            <?= $this->Html->link(
                'Delete',
                ['action' => 'delete', $user->employee_id],
                ['confirm' => 'Are you sure?'])
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php
     $paginator = $this->Paginator;
     echo "<div class = 'paging'> <ul class='ulClass'>";
     //for the first page link // the parameter’First’ is the labeled, same with other pagination link
     echo $paginator->first('First');
     echo " ";
     //if there was previous records, prev link will be displayed
     if($paginator->hasPrev()){
     echo $paginator->prev('<<');
     }
     //modulus => 3 specifies how many page number will be displayed
     echo $paginator->numbers(array('modulus' =>3)); 
     if($paginator->hasNext()){ //there are records, next link will be displayed
     echo $paginator->next('>>');
     }
     echo $paginator->last('Last'); //for the last page link
     echo "</ul></div>";
 ?> 
 <script type="text/javascript">
    $( document ).ready(function() {
        $('.serchBtn').click(function(){
            var searchText=$(".searchText").val();
            if($.trim(searchText)!=""){
                $('.searchForm').submit();
            }else{
                window.location.replace(window.location.href)
            }
        });
        $('.addBtn').click(function(){
            var pathname = window.location.pathname; // Returns path only (/path/example.html)
            var origin   = window.location.origin; 
            var lastChar = pathname[pathname.length -1];
            if(lastChar=='/'){
                window.location.replace(origin+pathname+"add");
            }else{
                window.location.replace(origin+pathname+"/add");
            }
        });
    });
 </script>