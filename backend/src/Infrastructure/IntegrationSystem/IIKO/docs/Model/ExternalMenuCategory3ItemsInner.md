# ExternalMenuCategory3ItemsInner

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**sku** | **string** | Product code | [optional] [default to '']
**name** | **string** | Product name | [optional] [default to '']
**description** | **string** | Product description | [optional] [default to '']
**item_sizes** | [**\IIKO\Model\ExternalMenuItemSize3[]**](ExternalMenuItemSize3.md) |  |
**modifier_schema_id** | **string** | Modifier schema ID |
**modifier_schema_name** | **string** | Modifier schema name | [optional]
**type** | **string** |  |
**can_set_open_price** | **bool** | Can set open price flag | [optional] [default to false]
**use_balance_for_sell** | **bool** |  | [optional] [default to false]
**measure_unit** | **string** | Measure unit | [optional] [default to '']
**product_category_id** | **string** | Product category GUID | [optional]
**customer_tag_groups** | [**\IIKO\Model\SelectedCustomerTag3[]**](SelectedCustomerTag3.md) |  | [optional]
**payment_subject** | **string** |  | [optional]
**payment_subject_code** | **string** |  | [optional]
**outer_ean_code** | **string** |  | [optional]
**is_marked** | **bool** | Marking flag | [optional] [default to false]
**is_hidden** | **bool** | Visibility flag | [optional] [default to false]
**barcodes** | [**\IIKO\Model\BarcodeDto4[]**](BarcodeDto4.md) |  | [optional]
**order_item_type** | **string** | Product or compound. Depends on modifiers scheme existence |
**tax_category_id** | **string** | Tax category GUID | [optional]
**allergen_group_ids** | **object[]** | List of GUID groups of allergens |
**labels** | **string[]** | List of labels | [optional]
**tags** | **string[]** | List of tags | [optional]
**id** | **string** | Product ID |
**splittable** | [**Bool**](Bool.md) |  |
**sizes** | [**\IIKO\Model\ExternalMenuComboItemSize[]**](ExternalMenuComboItemSize.md) |  |
**groups** | [**\IIKO\Model\ComboGroupDto4[]**](ComboGroupDto4.md) |  | [optional]
**price_strategy** | **string** | Price strategy | [optional] [default to 'BY_COMPONENT']

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
