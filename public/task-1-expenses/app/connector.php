<?php
/**
 * Read categories from file
 * @return array
 */
function get_categories()
{
    $result = array();

    if (file_exists($GLOBALS['config']['categories_path'])) 
    {
        $categories = file($GLOBALS['config']['categories_path']);

        // Convert each line to key=>value pair
        foreach ($categories as $category)
        {
            $dataArray = explode($GLOBALS['config']['data_separator'], $category);
            $result[$dataArray[0]] = $dataArray[1];
        }
    }

    return $result;
}

/**
 * Read expenses from file
 * @return array
 */
function get_expenses()
{
    $result = array();

    if (file_exists($GLOBALS['config']['expenses_path'])) 
    {
        $expenses = file($GLOBALS['config']['expenses_path']);
        
        foreach ($expenses as $expense)
        {
            $row = explode($GLOBALS['config']['data_separator'], $expense);
            $result[] = $row;
        }
    }
    
    return $result;
}

/**
 * Save expense to file
 * @param array $data
 * @return boolean
 */
function save_expense($data)
{
    $data[] = time();
    $row = generate_data_row($data);

    return file_put_contents('./data/expenses.txt', $row, FILE_APPEND);
}

/**
 * Generate new line of data with proper format for file
 * @param type $data
 * @return string
 */
function generate_data_row($data)
{
    return implode($GLOBALS['config']['data_separator'], $data).PHP_EOL;
}