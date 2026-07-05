# RetrieveExternalMenuRequestDto

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**external_menu_id** | **string** | External menu id                Can be obtained by &#x60;api/2/menu&#x60; operation. |
**organization_ids** | [**ArrayOfStringsUuid**](ArrayOfStringsUuid.md) | Organization IDs.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**price_category_id** | **string** | Price category id.                Can be obtained by &#x60;api/2/menu&#x60; operation. | [optional]
**version** | [**IntegerInt32**](IntegerInt32.md) | Version of the result data model. | [optional]
**language** | **string** | Language of the external menu. | [optional]
**async_mode** | **bool** | Async Mode. | [optional] [default to false]
**start_revision** | [**IntegerInt64**](IntegerInt64.md) | Start revision. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
