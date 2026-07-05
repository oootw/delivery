# ExternalMenuModifierItem4

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**sku** | **string** | Modifier&#39;s code | [optional] [default to '']
**name** | **string** | Modifier&#39;s name | [optional] [default to '']
**description** | **string** | Modifier&#39;s description | [optional] [default to '']
**restrictions** | [**\IIKO\Model\ModifierRestrictionsDto8[]**](ModifierRestrictionsDto8.md) |  | [optional]
**is_hidden** | **bool** |  | [optional] [default to false]
**prices** | [**\IIKO\Model\ExternalMenuPriceByDepartmentsDto4[]**](ExternalMenuPriceByDepartmentsDto4.md) |  | [optional]
**nutritions** | [**\IIKO\Model\NutritionInfoDto8[]**](NutritionInfoDto8.md) | Nutrition per 100 g of product grouped by departments | [optional]
**tax_category_id** | **string** |  | [optional]
**independent_quantity** | **bool** |  | [optional] [default to false]
**product_category_id** | **string** |  | [optional]
**customer_tag_groups** | [**\IIKO\Model\SelectedCustomerTag8[]**](SelectedCustomerTag8.md) |  | [optional]
**payment_subject** | **string** |  | [optional]
**outer_ean_code** | **string** |  | [optional]
**is_marked** | **bool** |  | [optional] [default to false]
**measure_unit_type** | **string** |  | [optional] [default to 'GRAM']
**payment_subject_code** | **string** |  | [optional]
**barcodes** | [**\IIKO\Model\BarcodeDto8[]**](BarcodeDto8.md) |  | [optional]
**button_image_url** | **string** |  | [optional]
**allergen_group_ids** | **object[]** |  |
**labels** | **object[]** | List of label names |
**tags** | **object[]** | List of tag names |
**id** | **string** |  |
**weight** | **float** |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
