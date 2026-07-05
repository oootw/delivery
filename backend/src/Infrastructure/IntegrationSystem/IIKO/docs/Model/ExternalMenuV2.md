# ExternalMenuV2

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**product_categories** | [**\IIKO\Model\ProductCategoryDto[]**](ProductCategoryDto.md) | Product categories | [optional]
**customer_tag_groups** | [**\IIKO\Model\CustomerTagGroup[]**](CustomerTagGroup.md) | Customer tag groups | [optional]
**revision** | **int** | Menu revision | [optional]
**format_version** | **int** | Menu version | [optional] [default to 2]
**id** | **int** | ID of the external menu |
**name** | **string** | External menu name | [optional] [default to '']
**description** | **string** | External menu description | [optional] [default to '']
**button_image_url** | **string** | Link to image | [optional]
**intervals** | [**\IIKO\Model\IntervalDto[]**](IntervalDto.md) | Menu availability time intervals | [optional]
**item_categories** | [**\IIKO\Model\ExternalMenuCategory[]**](ExternalMenuCategory.md) |  |
**combo_categories** | [**\IIKO\Model\ComboCategoryDto[]**](ComboCategoryDto.md) |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
