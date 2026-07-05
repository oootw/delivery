# ExternalMenuModifierGroup

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**name** | **string** | Modifiers group name | [optional] [default to '']
**description** | **string** | Modifiers group description | [optional] [default to '']
**restrictions** | [**\IIKO\Model\ModifierRestrictionsDto**](ModifierRestrictionsDto.md) |  | [optional]
**items** | [**\IIKO\Model\ExternalMenuModifierItem[]**](ExternalMenuModifierItem.md) |  | [optional]
**can_be_divided** | [**Bool**](Bool.md) |  | [optional]
**item_group_id** | **string** |  | [optional]
**is_hidden** | **bool** |  | [optional] [default to false]
**child_modifiers_have_min_max_restrictions** | **bool** | Whether child modifiers can have their own restrictions, or only group ones | [optional] [default to false]
**sku** | **string** | Modifiers group code | [optional] [default to '']

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
