# ExternalMenuItem2

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**sku** | **string** | Product code | [optional] [default to '']
**name** | **string** | Product name | [optional] [default to '']
**description** | **string** | Product description | [optional] [default to '']
**item_sizes** | [**\IIKO\Model\ExternalMenuItemSize2[]**](ExternalMenuItemSize2.md) |  |
**modifier_schema_id** | **string** | Modifier schema ID |
**modifier_schema_name** | **string** | Modifier schema name | [optional]
**type** | **string** | Item type | [optional] [default to 'DISH']
**can_set_open_price** | **bool** | Can set open price flag | [optional] [default to false]
**use_balance_for_sell** | **bool** |  | [optional] [default to false]
**measure_unit** | **string** | Measure unit | [optional] [default to '']
**product_category_id** | **string** | Product category GUID | [optional]
**customer_tag_groups** | [**\IIKO\Model\SelectedCustomerTag2[]**](SelectedCustomerTag2.md) |  | [optional]
**payment_subject** | **string** |  | [optional]
**payment_subject_code** | **string** |  | [optional]
**outer_ean_code** | **string** |  | [optional]
**is_marked** | **bool** | Marking flag | [optional] [default to false]
**is_hidden** | **bool** | Visibility flag | [optional] [default to false]
**barcodes** | [**\IIKO\Model\BarcodeDto2[]**](BarcodeDto2.md) |  | [optional]
**order_item_type** | **string** | Product or compound. Depends on modifiers scheme existence |
**tax_category_id** | **string** | Tax category GUID | [optional]
**allergen_group_ids** | **object[]** | List of GUID groups of allergens |
**labels** | **string[]** | List of labels | [optional]
**tags** | **string[]** | List of tags | [optional]
**id** | **string** | Product ID |
**splittable** | [**Bool**](Bool.md) |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
