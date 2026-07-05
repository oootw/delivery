# ExternalMenuCategory

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Category ID | [optional]
**name** | **string** | Category name | [optional] [default to '']
**description** | **string** | Category description | [optional] [default to '']
**button_image_url** | **string** | Link to image | [optional]
**header_image_url** | **string** |  | [optional]
**iiko_group_id** | **string** | iikoGroupId | [optional]
**items** | [**\IIKO\Model\ExternalMenuItem[]**](ExternalMenuItem.md) |  |
**schedule_id** | **string** | Category schedule GUID | [optional]
**schedule_name** | **string** | Category schedule name | [optional]
**schedules** | [**\IIKO\Model\PeriodScheduleDto[]**](PeriodScheduleDto.md) | Category schedule intervals | [optional]
**is_hidden** | **bool** | Visibility flag | [optional] [default to false]
**tags** | [**\IIKO\Model\TagDto[]**](TagDto.md) |  | [optional]
**labels** | [**\IIKO\Model\LabelDto[]**](LabelDto.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
