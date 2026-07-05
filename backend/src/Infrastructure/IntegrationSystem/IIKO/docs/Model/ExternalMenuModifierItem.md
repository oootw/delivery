# ExternalMenuModifierItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**sku** | **string** | Modifier&#39;s code | [optional] [default to '']
**name** | **string** | Modifier&#39;s name | [optional] [default to '']
**description** | **string** | Modifier&#39;s description | [optional] [default to '']
**restrictions** | [**\IIKO\Model\ModifierRestrictionsDto5[]**](ModifierRestrictionsDto5.md) |  | [optional]
**allergen_groups** | [**\IIKO\Model\AllergenGroupDto4[]**](AllergenGroupDto4.md) |  | [optional]
**nutrition_per_hundred_grams** | [**\IIKO\Model\NutritionInfoDto5[]**](NutritionInfoDto5.md) | Nutrition per 100 g of modifier product | [optional]
**portion_weight_grams** | **float** | Modifier&#39;s weight in gramms | [optional]
**tags** | [**\IIKO\Model\TagDto3[]**](TagDto3.md) | List of tag names | [optional]
**labels** | [**\IIKO\Model\LabelDto3[]**](LabelDto3.md) | List of label names | [optional]
**item_id** | **string** | Modifier&#39;s Id | [optional]
**is_hidden** | **bool** |  | [optional] [default to false]
**prices** | [**\IIKO\Model\ExternalMenuPriceByDepartmentsDto[]**](ExternalMenuPriceByDepartmentsDto.md) |  | [optional]
**position** | **int** |  | [optional]
**independent_quantity** | **bool** |  | [optional] [default to false]
**product_category_id** | **string** |  | [optional]
**customer_tag_groups** | [**\IIKO\Model\SelectedCustomerTag5[]**](SelectedCustomerTag5.md) |  | [optional]
**payment_subject** | **string** |  | [optional]
**outer_ean_code** | **string** |  | [optional]
**is_marked** | **bool** |  | [optional] [default to false]
**measure_unit_type** | **string** |  | [optional] [default to 'GRAM']
**payment_subject_code** | **string** |  | [optional]
**barcodes** | [**\IIKO\Model\BarcodeDto5[]**](BarcodeDto5.md) |  | [optional]
**button_image_url** | **string** |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
