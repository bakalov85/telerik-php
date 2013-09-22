<?php
/**
 * Generate page title
 * @param string $pageTitle
 * @return string
 */
function page_title($pageTitle)
{
    $title = '';
    if ($pageTitle)
    {
        $title .= $pageTitle . ' | ';
    }
    $title .= $GLOBALS['config']['base_title'];
    return $title;
}

/**
 * Generate total expenses
 * @param type $arr
 * @param type $priceIndex
 * @return type
 */
function calc_total_cost($arr, $priceIndex = 2)
{
    $total = 0;
    foreach ($arr as $value)
    {
        $total += $value[$priceIndex];
    }
    return $total;
}

/**
 * Convert price to more human readable
 * @param type $price
 * @return type
 */
function humanize_price($price)
{
    return sprintf($GLOBALS['config']['price_format'], number_format($price, 2));
}

/**
 * Convert expense data to more human readable
 * @param type $data
 * @param type $categories
 * @param type $categoryIndex
 * @param type $priceIndex
 * @param type $dateIndex
 * @return type
 */
function humanize_expense_data($data, $categories, $categoryIndex = 1, $priceIndex = 2, $dateIndex = 3)
{
    foreach ($data as &$row)
    {
        $row[$priceIndex] = humanize_price($row[$priceIndex]);
        $row[$categoryIndex] = $categories[$row[$categoryIndex]];
        $row[$dateIndex] = date($GLOBALS['config']['date_format'], (int) $row[$dateIndex]);
    }
    return $data;
}

/**
 * Generate input type select
 * @param type $name
 * @param type $options
 * @param type $default
 * @return type
 */
function input_select($name, $options, $default = NULL)
{
    $html = '<select name="' . $name . '">';

    foreach ($options as $key => $value)
    {
        $html .= '<option value="' . $key . '"';

        if ($default == $key)
        {
            $html .= ' selected="selected"';
        }

        $html .= '>' . $value . '</option>';
    }
    $html .= '</select>';
    return $html;
}

/**
 * Filter array by value
 * @param type $data
 * @param type $filter
 * @param type $filterIndex
 * @return type
 */
function filter_data($data, $filter, $filterIndex = 1) 
{
    foreach ($data as $key => $value)
    {
        if($value[$filterIndex] != $filter)
        {
            unset($data[$key]);
        }
    }
    return $data;
}