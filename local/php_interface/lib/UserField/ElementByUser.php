<?php

namespace MTai\UserField;

use Bitrix\Main\Localization\Loc;
use Bitrix\Iblock\UserField\Types\ElementType;
use CUserTypeManager;
use Bitrix\Main\Loader;
use Bitrix\Main\Engine\CurrentUser;
use CIBlockElementEnum;
use CDBResult;

Loader::includeModule("iblock");

class ElementByUser extends ElementType
{
	public const
		USER_TYPE_ID = 'iblock_element_by_user',
		RENDER_COMPONENT = 'mtai:iblock.field.element_by_user';

	/**
	 * @return array
	 */
	public static function getDescription(): array
	{
		return [
			'DESCRIPTION' => Loc::getMessage('USER_TYPE_IBEL_BY_USER_DESCRIPTION'),
			'BASE_TYPE' => CUserTypeManager::BASE_TYPE_INT,
            "CLASS_NAME" => __CLASS__,
            "USER_TYPE_ID" => self::USER_TYPE_ID,
		];
	}

    /**
     * @param array $userField
     * @return array
     */
    public static function prepareSettings(array $userField): array
    {
        $result = parent::prepareSettings($userField);
        $result["USER_FIELD_CODE"] = $userField['SETTINGS']['USER_FIELD_CODE'];

        return $result;
    }

    /**
     * @param array $userField
     * @return bool|CDBResult
     */
    public static function getList(array $userField)
    {
        if(self::$iblockIncluded === null)
        {
            self::$iblockIncluded = Loader::includeModule('iblock');
        }

        $elementEnumList = false;

        if(self::$iblockIncluded && (int)$userField['SETTINGS']['IBLOCK_ID'])
        {
            $userFieldCode = empty($userField['SETTINGS']["USER_FIELD_CODE"])
                ? "CREATED_BY"
                : $userField['SETTINGS']["USER_FIELD_CODE"];

            $filter = ['IBLOCK_ID' => (int)$userField['SETTINGS']['IBLOCK_ID']];
            if($userField['SETTINGS']['ACTIVE_FILTER'] === 'Y')
            {
                $filter['ACTIVE'] = 'Y';
            }
            $filter['='.$userFieldCode] = CurrentUser::get()->getId();

            $result = \CIBlockElement::GetList(
                ['NAME' => 'ASC', 'ID' => 'ASC'],
                $filter,
                false,
                false,
                ['ID', 'NAME']
            );

            if($result)
            {
                $elementEnumList = new CIBlockElementEnum($result);
            }
        }
        return $elementEnumList;
    }
}
