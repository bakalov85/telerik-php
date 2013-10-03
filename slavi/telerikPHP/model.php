<?php

class Model {

    public static $error = array();
    public static $data = array();

    //Select Data from database(files)    
    public function selectData($filename) {
        if (file_exists($filename)) {
            $file = file($filename);
            $line = array();
            if (is_array($file) && !empty($file)) {
                foreach ($file as $key => $value) {
                    $line[] = explode("|", $file[$key]);
                }
                return $line;
            } else {
                return false;
            }
        } else {
            throw new Exception("Ivalid file - " . $filename);
        }
    }

    //INSERT IN FILE(NEW recording)
    public function insertData($filename, $data) {
        if (file_exists($filename)) {
            if (filesize($filename) == 0) {
                $id = 1;
            } else {
                $id = $this->getLastId($filename);
            }
            $data = $id . '|' . $data['name'] . '|' . $data['cash'] . '|' . $data['category'] . '|' . date('d-m-y') . "\n";
            if (!file_put_contents($filename, $data, FILE_APPEND)) {
                throw new Exception("Database error.");
            } else {
                return true;
            }
        }
    }

    //Get last id from file
    public function getLastId($filename) {
        try {
            $getid = file($filename);
            $getid = explode("|", $getid[count($getid) - 1]);
            $id = (int) $getid[0] + 1;
        } catch (Exception $err) {
            echo $err->getMessage();
        }
        return $id;
    }

    //Two option: if file is empty put default categoryes from array (in config.php)
    //Or add new category from front-end form
    public function setCategory($filename, $data = null) {
        if (file_exists($filename)) {
            if (filesize($filename) == 0) {
                //append default category
                //get defaultCategory from config.php
                global $defaultCategory;
                foreach ($defaultCategory as $key => $category) {
                    $data = $key . "|" . $category . "\n";
                    if (!file_put_contents($filename, $data, FILE_APPEND)) {
                        throw new Exception("File reading error.");
                    }
                }
            } else {
                if ($data != null) {
                    $id = $this->getLastId($filename);
                    $data = $id . "|" . $data . "\n";
                    if (!file_put_contents($filename, $data, FILE_APPEND)) {
                        throw new Exception("File reading error.");
                    }
                }
            }
        }
    }

    //this method have to be place in controller
    public function validateData($data) {
        mb_internal_encoding("UTF-8");
        //normalize data
        $name = trim($data['name']);
        $cash = trim($data['cash']);
        $category = (int) $data['category'];
        //validate data
        if (mb_strlen($name) < 3) {
            self::$error[] = 'Name must be less 6 letters and not bigger than 12 letters.';
        }
        if (!($cash > 0)) {
            self::$error[] = 'Cash must be more than 0.';
        }
        if ($category == 0) {
            self::$error[] = 'Please select category.';
        }
        if (count(self::$error) > 0) {
            return false;
        } else {
            self::$data['name'] = $name;
            self::$data['cash'] = $cash;
            //send category name not number
            $getCategory = $this->selectData(CATEGORY);
            foreach ($getCategory as $value) {
                if (in_array($category, $value)) {
                    $category = $value[1];
                }
            }
            self::$data['category'] = trim($category);
            return true;
        }
    }

    //This method update previous saved data
    public function checkLineAndUpdate($dataFile, $data, $id) {

        $name = $data['name'];
        $cash = $data['cash'];
        $category = $data['category'];
        try {
            $file = file($dataFile);

            $line = 0; //get line
            foreach ($file as $value) {
                $chunk = explode("|", $value); //explode file
                if ($chunk[0] == $id) {//if file id == $_GET["id"]
                    $update = $chunk[0] . "|" . $name . "|" . $cash . "|" . $category . "|" . date('d-m-y');
                    $file[$line] = $update; //change data in file array
                }
                $line++;
            }
            $newData = "";
            foreach ($file as $value) {
                $newData .= trim($value) . "\n";
            }
            if (!file_put_contents($dataFile, $newData)) {
                throw new Exception("File reading error.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    //Remove items from listing
    public function removeItem($filename, $id) {
        try {
            $file = file($filename);
            if (!(count($file) > 0))
                return; //file is empty
            foreach ($file as $key => $value) {
                $getID = explode("|", $value);
                if ($getID[0] == $id) {
                    unset($file[$key]);
                }
            }
            $newData = '';
            foreach ($file as $value) {
                $newData .= trim($value) . "\n";
            }
            if (!file_put_contents($filename, $newData)) {
                throw new Exception("File reading error.");
            }
        } catch (Exception $err) {
            $err->getMessage();
        }
    }

}