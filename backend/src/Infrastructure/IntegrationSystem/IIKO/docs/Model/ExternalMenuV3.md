# ExternalMenuV3

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**tax_categories** | [**\IIKO\Model\TaxCategoryDto[]**](TaxCategoryDto.md) | Tax Categories | [optional]
**product_categories** | [**\IIKO\Model\ProductCategoryDto2[]**](ProductCategoryDto2.md) | Product categories | [optional]
**allergen_groups** | [**\IIKO\Model\AllergenGroupDto[]**](AllergenGroupDto.md) | Allergen groups | [optional]
**customer_tag_groups** | [**\IIKO\Model\CustomerTagGroup2[]**](CustomerTagGroup2.md) | Customer tag groups | [optional]
**override_tax_categories** | [**\IIKO\Model\OverrideTaxesDto[]**](OverrideTaxesDto.md) | Tax benefits | [optional]
**revision** | **int** | Menu revision | [optional]
**format_version** | **int** | Menu version | [optional] [default to 2]
**id** | **int** | ID of the external menu |
**name** | **string** | External menu name | [optional] [default to '']
**description** | **string** | External menu description | [optional] [default to '']
**button_image_url** | **string** | Link to image | [optional]
**intervals** | [**\IIKO\Model\IntervalDto2[]**](IntervalDto2.md) | Menu availability time intervals | [optional]
**combo_categories** | [**\IIKO\Model\ComboCategoryDto2[]**](ComboCategoryDto2.md) |  |
**item_groups** | [**\IIKO\Model\ExternalMenuCategory2[]**](ExternalMenuCategory2.md) |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
