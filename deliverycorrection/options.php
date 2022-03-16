<style type="text/css">
    .column-name {
        width: 50%;
    }
    .column-value {
        width: 50%;
    }
</style>
<?
global $USER;
if (!$USER->IsAdmin()) {
    return;
}
IncludeModuleLangFile(__FILE__);
const moduleID = 'deliverycorrection';
$module_id = moduleID;
CModule::IncludeModule(moduleID);

$aTabs = array(
    array("DIV" => "edit1", "TAB" => GetMessage("MAIN_TAB_SET"), "ICON" => "form_settings", "TITLE" => GetMessage("MAIN_TAB_TITLE_SET")),
);

$tabControl = new CAdminTabControl("tabControl", $aTabs);

if ($REQUEST_METHOD == "POST" && strlen($Update.$Apply.$RestoreDefaults) > 0 && check_bitrix_sessid()) {
    if (strlen($RestoreDefaults) > 0) {
        COption::RemoveOption(moduleID);
    } else {
        \Bitrix\Main\Config\Option::set(moduleID, 'xml_id_ru', $_REQUEST['xml_id_ru'], false);
        \Bitrix\Main\Config\Option::set(moduleID, 'xml_id_all', $_REQUEST['xml_id_all'], false);
        \Bitrix\Main\Config\Option::set(moduleID, 'order_summ', $_REQUEST['order_summ'], false);
        \Bitrix\Main\Config\Option::set(moduleID, 'delivery_price', $_REQUEST['delivery_price'], false);
    }
    if (strlen($Update) > 0 && strlen($_REQUEST["back_url_settings"]) > 0) {
        LocalRedirect($_REQUEST["back_url_settings"]);
    } else {
        LocalRedirect($APPLICATION->GetCurPage()."?mid=".urlencode($mid)."&lang=".urlencode(LANGUAGE_ID)."&back_url_settings=".urlencode($_REQUEST["back_url_settings"])."&".$tabControl->ActiveTabParam());
    }
}

$tabControl->Begin();
$tabControl->BeginNextTab();?>
<form method="POST" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&amp;lang=<?=LANGUAGE_ID?>">
    <?=bitrix_sessid_post();?>
    <tr>
        <td class="column-name"><?=GetMessage("TEXT_RU")?></td>
        <td class="column-value">
            <input type="text" name="xml_id_ru" value="<?=(string)\Bitrix\Main\Config\Option::get(moduleID, 'xml_id_ru')?>" />
        </td>
    </tr>
    <tr>
        <td class="column-name"><?=GetMessage("TEXT_ALL")?></td>
        <td class="column-value">
            <input type="text" name="xml_id_all" value="<?=(string)\Bitrix\Main\Config\Option::get(moduleID, 'xml_id_all')?>" />
        </td>
    </tr>
    <tr>
        <td class="column-name"><?=GetMessage("TEXT_FIX")?></td>
        <td class="column-value">
            <input type="text" placeholder="<?=GetMessage("ORDER_SUMM")?>" name="order_summ" value="<?=(string)\Bitrix\Main\Config\Option::get(moduleID, 'order_summ')?>" />
            <input type="text" placeholder="<?=GetMessage("DELIVERY_PRICE")?>" name="delivery_price" value="<?=(string)\Bitrix\Main\Config\Option::get(moduleID, 'delivery_price')?>" />
        </td>
    </tr>

    <?$tabControl->Buttons();?>
    <input type="submit" name="Update" value="<?=GetMessage("MAIN_SAVE")?>" title="<?=GetMessage("MAIN_OPT_SAVE_TITLE")?>" class="adm-btn-save">
    <?$tabControl->End();?>
</form>


