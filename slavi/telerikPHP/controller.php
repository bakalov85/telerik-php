<?php

class Controller {

    public $model = null;

    public function __construct() {
        //instance model
        $this->model = new Model();
        //get view
        $view = isset($_GET["view"]) ? $_GET["view"] : "";
        //get task
        $task = isset($_GET["task"]) ? $_GET["task"] : "";
        //check if form is submited
        $submit = isset($_POST['check']) ? $_POST['check'] : 0;
        //check on which layout I am
        if ($view == "addExpense") {
            $this->addExpense($task, $submit);
        } else if ($view == "addCategory") {
            $this->addCategory($submit, $task);
        } else {
            $this->defaultListing($task);
        }
    }

    public function addExpense($task, $submit) {
        //get category
        $category = $this->model->selectData(CATEGORY);
        //EDIT MODE
        if ($submit == 1) {
            //form is submited and we can validate data
            $data = $this->model->validateData($_POST);
            if (!$data) {
                View::parseToLayout('errors', Model::$error);
            } else {
                if (isset($_GET['id'])) {
                    //edit mode
                    $this->model->checkLineAndUpdate(USER_EXPENSE, Model::$data, $_GET['id']);
                    View::parseToLayout('success', true);
                } else {
                    $this->model->insertData(USER_EXPENSE, Model::$data);
                    View::parseToLayout('success', true);
                }
            }
        }
        //parse to layout to category

        if (isset($_GET['id']) && $task == "edit") {
            View::setTitle("Edit Expense");
            View::setLayout("addExpense.php");
            $data = $this->model->selectData(USER_EXPENSE);
            View::parseToLayout('category', $category);
            foreach ($data as $value) {
                if (in_array($_GET['id'], $value)) {
                    View::parseToLayout("editData", $value);
                }
            }
        } else {
            View::setTitle("Add Expense");
            View::setLayout("addExpense.php");
            View::parseToLayout('category', $category);
        }
    }

    public function defaultListing($task) {
        //Here we are in default layout index.php
        if ($task == "remove") {
            $this->model->removeItem(USER_EXPENSE, (int) $_GET["id"]);
        }
        //if category file is empty append default category
        $this->model->setCategory(CATEGORY);
        $listing = $this->model->selectData(USER_EXPENSE);
        //create filter
        $dateFilter = "";
        if (isset($_POST['dateFilter']) && !empty($_POST['dateFilter'])) {

            $dateFilter = $_POST['dateFilter'];
        }

        if ($task == "filter") {
            $filter = trim($_POST['category']);
            $filetrListing = array();
            if (!empty($listing)) {
                foreach ($listing as $value) {

                    if (!empty($dateFilter) && $filter != "null") {
                        if (in_array($filter, $value) && strtotime($dateFilter) == strtotime($value[4])) {
                            $filetrListing[] = $value;
                        }
                    } else if (!empty($dateFilter) && $filter == "null") {
                        if ((strtotime($dateFilter) == strtotime($value[4]))) {
                            $filetrListing[] = $value;
                        }
                    } else if (empty($dateFilter) && $filter != "null") {
                        if (in_array($filter, $value)) {
                            $filetrListing[] = $value;
                        }
                    }
                }
            }
        }
        //get category
        $category = $this->model->selectData(CATEGORY);
        //parse category array
        View::parseToLayout('category', $category);
        //check mode for filter
        if (( $task == "filter" && !stristr($filter, "null") ) || !empty($dateFilter)) {
            //send filtered array
            View::parseToLayout('listing', $filetrListing);
            View::parseToLayout('filter', $filter);
            View::parseToLayout('dateFilter', $dateFilter);
        } else {
            //send all listing items
            View::parseToLayout('listing', $listing);
        }
        //set header title
        View::setTitle("Home");
        //set default layout
        View::setLayout("default.php");
    }

    public function addCategory($submit, $task) {
        if ($submit == 1 && $task == "addCategory") {
            if ($this->validateCategory($_POST["category"])) {
                View::parseToLayout("success", "success");
                $this->model->setCategory(CATEGORY, $_POST["category"]);
            } else {
                View::parseToLayout("error", "Category have to be more than 3 character.");
            }
        }
        View::setTitle("Add Category");
        View::setLayout("addCategory.php");
    }

    /*
     * this method check if user category input data is valid
     * 
     */

    private function validateCategory($data) {
        mb_internal_encoding("UTF-8");
        $category = trim($data);

        if (mb_strlen($category) > 3) {
            return true;
        } else {
            return false;
        }
    }

}