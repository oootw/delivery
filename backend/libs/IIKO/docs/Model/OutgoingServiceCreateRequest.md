# OutgoingServiceCreateRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**comment** | **string** | Comment | [optional]
**conception** | **string** | Concept identifier (GUID) | [optional]
**contract_date** | **string** | Contract date (ISO 8601 YYYY-MM-DDThh:mm:ss±hh:mm) | [optional]
**contract_number** | **string** | Contract number | [optional]
**counteragent** | **string** | Counteragent identifier (GUID) |
**date** | **string** | Document date and time (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) |
**document_id** | **string** |  | [optional]
**due_date** | **string** | Payment due date | [optional]
**is_automatic** | **bool** | Automatic document creation flag | [optional]
**is_editable** | **bool** | Editable flag. true — available for editing in RMS | [optional]
**items** | [**\IIKO\Model\OutgoingServiceCreateItem[]**](OutgoingServiceCreateItem.md) | List of document items |
**number** | **string** | Document number | [optional]
**organization_id** | **string** | Organization identifier (GUID) |
**revenue_account** | **string** | Revenue account identifier (GUID) | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
