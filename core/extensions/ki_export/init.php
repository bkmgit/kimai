<?php

// ==================================
// = implementing standard includes =
// ==================================
include('../../includes/basics.php');

require("private_func.php");

$usr = checkUser();

// ============================================
// = initialize currently displayed timespace =
// ============================================
$timespace = get_timespace();
$in = $timespace[0];
$out = $timespace[1];

// set smarty config
require_once('../../libraries/smarty/Smarty.class.php');
$tpl = new Smarty();
$tpl->template_dir = 'templates/';
$tpl->compile_dir  = 'compile/';

$tpl->assign('kga', $kga);

$tpl->display('panel.tpl');


// ==========================
// = display timesheet area =
// ==========================
$total = intervallApos(get_zef_time($in,$out,null,array($kga['customer']['knd_ID']),null));

$arr_zef = xp_get_arr($in,$out,null,array($kga['customer']['knd_ID']),null);

if (count($arr_zef)>0) {
    $tpl->assign('arr_data', $arr_zef);
} else {
    $tpl->assign('arr_data', 0);
}
$tpl->assign('total', $total);

$ann = xp_get_arr_usr($in,$out,null,array($kga['customer']['knd_ID']));
$ann_new = intervallApos($ann);
$tpl->assign('usr_ann',$ann_new);

$ann = xp_get_arr_knd($in,$out,null,array($kga['customer']['knd_ID']));
$ann_new = intervallApos($ann);
$tpl->assign('knd_ann',$ann_new);

$ann = xp_get_arr_pct($in,$out,null,array($kga['customer']['knd_ID']));
$ann_new = intervallApos($ann);
$tpl->assign('pct_ann',$ann_new);

$ann = xp_get_arr_evt($in,$out,null,array($kga['customer']['knd_ID']));
$ann_new = intervallApos($ann);
$tpl->assign('evt_ann',$ann_new);

$disabled_columns = xp_get_disabled_headers($kga['usr']['usr_ID']);

$tpl->assign('disabled_columns',$disabled_columns);

$tpl->assign('table_display', $tpl->fetch("table.tpl"));

$tpl->display('main.tpl');

?>