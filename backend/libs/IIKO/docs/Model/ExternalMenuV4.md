# ExternalMenuV4

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**tax_categories** | [**\IIKO\Model\TaxCategoryDto2[]**](TaxCategoryDto2.md) | Tax Categories | [optional]
**product_categories** | [**\IIKO\Model\ProductCategoryDto3[]**](ProductCategoryDto3.md) | Product categories | [optional]
**allergen_groups** | [**\IIKO\Model\AllergenGroupDto2[]**](AllergenGroupDto2.md) | Allergen groups | [optional]
**customer_tag_groups** | [**\IIKO\Model\CustomerTagGroup3[]**](CustomerTagGroup3.md) | Customer tag groups | [optional]
**override_tax_categories** | [**\IIKO\Model\OverrideTaxesDto2[]**](OverrideTaxesDto2.md) | Tax benefits | [optional]
**revision** | **int** | Menu revision | [optional]
**format_version** | **int** | Menu version | [optional] [default to 2]
**id** | **int** | ID of the external menu |
**name** | **string** | External menu name | [optional] [default to '']
**description** | **string** | External menu description | [optional] [default to '']
**button_image_url** | **string** | Link to image | [optional]
**intervals** | [**\IIKO\Model\IntervalDto3[]**](IntervalDto3.md) | Menu availability time intervals | [optional]
**combo_categories** | [**\IIKO\Model\ComboCategoryDto3[]**](ComboCategoryDto3.md) |  |
**item_groups** | [**\IIKO\Model\ExternalMenuCategory3[]**](ExternalMenuCategory3.md) |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
