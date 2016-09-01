<?php

/* 
 * Created by Roberto Júnior
 */

$config['full_tag_open'] = '<nav class="ui pagination menu">';
$config['full_tag_close'] = '</nav>';
$config['first_link'] = false;
$config['last_link'] = false;
$config['next_link'] = '<i class="right arrow icon"></i>';
$config['next_tag_open'] = '<span class="icon item">';
$config['next_tag_close'] = '</span>';
$config['prev_link'] = '<i class="left arrow icon"></i>';
$config['prev_tag_open'] = '<span class="icon item">';
$config['prev_tag_close'] = '</span>';
$config['cur_tag_open'] = '<span class="active item">';
$config['cur_tag_close'] = '</span>';
$config['attributes'] = array('class' => 'item');


$config['use_page_numbers'] = TRUE;
$config['page_query_string'] = TRUE;
$config['num_links'] = 10;
$config['first_url'] = "?per_page=1";