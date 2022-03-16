<?
if (class_exists("deliverycorrection"))
    return;

Class deliverycorrection extends CModule
{
    public $MODULE_ID = "deliverycorrection";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_GROUP_RIGHTS = "Y";
    private $MODULE_OPTIONS=[
        "xml_id_ru"=>10,
        "xml_id_all"=>100,
        "order_summ"=>20000,
        "delivery_price"=>500
    ];


    function deliverycorrection()
    {
        $arModuleVersion = [];

        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path."/version.php");
        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }
        $this->MODULE_NAME = "Модуль корректировки стоимости доставки";
        $this->MODULE_DESCRIPTION = "Модуль корректировки стоимости доставки";

    }

    function DoInstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        // Install events
        RegisterModuleDependences("sale","onSaleDeliveryServiceCalculate",$this->MODULE_ID,"cDeliverycorrection","onSaleDeliveryServiceCalculateHandler");

        foreach ($this->MODULE_OPTIONS as $options=>$value)
            \Bitrix\Main\Config\Option::set($this->MODULE_ID, $options, $value, false);

        RegisterModule($this->MODULE_ID);

        echo CAdminMessage::ShowNote("Модуль установлен");
    }

    function DoUninstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        foreach ($this->MODULE_OPTIONS as $options=>$value)
            \Bitrix\Main\Config\Option::delete($this->MODULE_ID, ['name'=> $options]);

        UnRegisterModuleDependences("sale","onSaleDeliveryServiceCalculate",$this->MODULE_ID,"cDeliverycorrection","onSaleDeliveryServiceCalculateHandler");
        UnRegisterModule($this->MODULE_ID);
        echo CAdminMessage::ShowNote("Модуль успешно удален из системы");
    }
}