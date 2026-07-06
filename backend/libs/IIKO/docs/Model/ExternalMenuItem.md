# ExternalMenuItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**sku** | **string** | Product code | [optional] [default to '']
**name** | **string** | Product name | [optional] [default to '']
**description** | **string** | Product description | [optional] [default to '']
**allergens** | [**\IIKO\Model\AllergenGroupDto3[]**](AllergenGroupDto3.md) | Allergens | [optional]
**tags** | [**\IIKO\Model\TagDto2[]**](TagDto2.md) |  | [optional]
**labels** | [**\IIKO\Model\LabelDto2[]**](LabelDto2.md) |  | [optional]
**item_sizes** | [**\IIKO\Model\ExternalMenuItemSize[]**](ExternalMenuItemSize.md) |  |
**item_id** | **string** | Product ID | [optional] [default to '']
**modifier_schema_id** | **string** | Modifier schema ID |
**tax_category** | [**\IIKO\Model\TaxCategoryDto3[]**](TaxCategoryDto3.md) | Tax category |
**modifier_schema_name** | **string** | Modifier schema name | [optional]
**type** | **string** | Item type | [optional] [default to 'DISH']
**can_be_divided** | [**Bool**](Bool.md) |  | [optional]
**can_set_open_price** | **bool** | Can set open price flag | [optional] [default to false]
**use_balance_for_sell** | **bool** |  | [optional] [default to false]
**measure_unit** | **string** | Measure unit | [optional] [default to '']
**product_category_id** | **string** | Product category GUID | [optional]
**customer_tag_groups** | [**\IIKO\Model\SelectedCustomerTag[]**](SelectedCustomerTag.md) |  | [optional]
**payment_subject** | **string** |  | [optional]
**payment_subject_code** | **string** |  | [optional]
**outer_ean_code** | **string** |  | [optional]
**is_marked** | **bool** | Marking flag | [optional] [default to false]
**is_hidden** | **bool** | Visibility flag | [optional] [default to false]
**barcodes** | [**\IIKO\Model\BarcodeDto[]**](BarcodeDto.md) |  | [optional]
**order_item_type** | **string** | Product or compound. Depends on modifiers scheme existence |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
