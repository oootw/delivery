# ExternalMenuItemSize2

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**sku** | **string** | Unique size code, consists of the product code and the name of the size, if the product has one size, then the size code will be equal to the product code | [optional] [default to '']
**size_code** | **string** |  | [optional]
**size_name** | **string** | Name of the product size, the name can be empty if there is only one size in the list | [optional]
**is_default** | **bool** | Whether it is a default size of the product. If the product has one size, then the parameter will be true, if the product has several sizes, none of them can be default. | [optional] [default to false]
**item_modifier_groups** | [**\IIKO\Model\ExternalMenuModifierGroup2[]**](ExternalMenuModifierGroup2.md) |  |
**prices** | [**\IIKO\Model\ExternalMenuPriceByDepartmentsDto2[]**](ExternalMenuPriceByDepartmentsDto2.md) |  | [optional]
**nutritions** | [**\IIKO\Model\NutritionInfoDto2[]**](NutritionInfoDto2.md) | Nutrition per 100 g of product grouped by departments | [optional]
**is_hidden** | **bool** |  | [optional] [default to false]
**measure_unit_type** | **string** |  | [optional] [default to 'GRAM']
**button_image_url** | **string** | links to images | [optional]
**weight** | **float** |  |
**id** | **string** |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
