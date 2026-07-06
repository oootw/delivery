# IncomingServiceUpdateRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**comment** | **string** | Comment | [optional]
**conception** | **string** | Concept identifier (GUID) | [optional]
**contract_date** | **string** | Contract date (ISO 8601 YYYY-MM-DDThh:mm:ss±hh:mm) | [optional]
**contract_number** | **string** | Contract number | [optional]
**counteragent** | **string** | Counteragent identifier (GUID) |
**date** | **string** | Document date and time (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) |
**document_id** | **string** | Document identifier (GUID) |
**due_date** | **string** | Payment due date | [optional]
**employee_pass_to_account** | **string** | Charge to employee | [optional]
**incoming_date** | **string** | Incoming document date (YYYY-MM-DD) | [optional]
**incoming_document_number** | **string** | Incoming external document number | [optional]
**invoice** | **string** | Invoice number | [optional]
**is_automatic** | **bool** | Automatic document creation flag | [optional]
**is_editable** | **bool** | Editable flag. true — available for editing in RMS | [optional]
**items** | [**\IIKO\Model\IncomingServiceCreateItem[]**](IncomingServiceCreateItem.md) | List of document items |
**number** | **string** | Document number |
**organization_id** | **string** | Organization identifier (GUID) |
**revenue_account** | **string** | Revenue account identifier (GUID) | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
