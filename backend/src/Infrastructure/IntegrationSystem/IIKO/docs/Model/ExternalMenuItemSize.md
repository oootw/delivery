# ExternalMenuItemSize

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**sku** | **string** | Unique size code, consists of the product code and the name of the size, if the product has one size, then the size code will be equal to the product code | [optional] [default to '']
**size_code** | **string** |  | [optional]
**size_name** | **string** | Name of the product size, the name can be empty if there is only one size in the list | [optional]
**is_default** | **bool** | Whether it is a default size of the product. If the product has one size, then the parameter will be true, if the product has several sizes, none of them can be default. | [optional] [default to false]
**portion_weight_grams** | **float** | Size&#39;s weight | [optional]
**item_modifier_groups** | [**\IIKO\Model\ExternalMenuModifierGroup[]**](ExternalMenuModifierGroup.md) |  |
**size_id** | **string** | ID size, can be empty if the default size is selected and it is the only size in the list |
**nutrition_per_hundred_grams** | [**\IIKO\Model\NutritionInfoDto[]**](NutritionInfoDto.md) | Nutrition per 100 g of product |
**prices** | [**\IIKO\Model\ExternalMenuPriceByDepartmentsDto[]**](ExternalMenuPriceByDepartmentsDto.md) |  | [optional]
**nutritions** | [**\IIKO\Model\NutritionInfoDto[]**](NutritionInfoDto.md) | Nutrition per 100 g of product grouped by departments | [optional]
**is_hidden** | **bool** |  | [optional] [default to false]
**measure_unit_type** | **string** |  | [optional] [default to 'GRAM']
**button_image_url** | **string** | links to images | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
