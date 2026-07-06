# ComboGroupDto4

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | [**Uuid**](Uuid.md) |  |
**name** | **string** |  |
**is_main_group** | **bool** | Includes main dishes - these are the items around which the combo set is built. If a main dish is added to the order, the system can display a prompt &#39;build a combo set&#39;. |
**items** | [**\IIKO\Model\ComboGroupItemDto4[]**](ComboGroupItemDto4.md) |  | [optional]
**skip_step** | **bool** |  | [optional] [default to false]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
