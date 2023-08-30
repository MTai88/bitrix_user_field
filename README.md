## Bitrix custom user field type

### 1. `MTai\UserField\ElementByUser` - Link to elements (drop-down list) filtered by current user Id
In the property options, enter the property code of the linked iblock with user id column on which filtering will be performed.
By default, filtering will be performed by the CREATED_BY column of the authorized user Id.

## Notes
- ```/local/php_interface/autoload.php``` - Class autoloader
- ```/local/php_interface/event_handler.php``` - Event handler to add custom user field type
- ```/local/components/mtai/iblock.field.element_by_user/``` - Component to render field
- ```/local/templates/.default/components/bitrix/system.field.edit``` and ```/local/templates/.default/components/bitrix/system.field.view``` - templates to display field in CRM entities
