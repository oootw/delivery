# ExternalMenuCategory3

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Category ID | [optional]
**name** | **string** | Category name | [optional] [default to '']
**description** | **string** | Category description | [optional] [default to '']
**button_image_url** | **string** | Link to image | [optional]
**iiko_group_id** | **string** | iikoGroupId | [optional]
**schedule_id** | **string** | Category schedule GUID | [optional]
**schedule_name** | **string** | Category schedule name | [optional]
**schedules** | [**\IIKO\Model\PeriodScheduleDto3[]**](PeriodScheduleDto3.md) | Category schedule intervals | [optional]
**is_hidden** | **bool** | Visibility flag | [optional] [default to false]
**items** | [**\IIKO\Model\ExternalMenuCategory3ItemsInner[]**](ExternalMenuCategory3ItemsInner.md) |  |
**labels** | **string[]** | List of labels | [optional]
**tags** | **string[]** | List of tags | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
