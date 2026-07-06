# IncomingServiceGetResponse

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**comment** | **string** | Comment | [optional]
**conception** | **string** | Concept identifier (GUID) | [optional]
**contract_date** | **string** | Contract date (ISO 8601 YYYY-MM-DDThh:mm:ss±hh:mm) | [optional]
**contract_number** | **string** | Contract number | [optional]
**counteragent** | **string** | Counteragent identifier (GUID) | [optional]
**date** | **string** | Document date and time (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) | [optional]
**date_created** | **string** | Document creation date (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) | [optional]
**date_modified** | **string** | Document last modification date (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) | [optional]
**document_id** | **string** | Document identifier (GUID) | [optional]
**due_date** | **string** | Payment due date | [optional]
**employee_pass_to_account** | **string** | Charge to employee | [optional]
**incoming_date** | **string** | Incoming document date (YYYY-MM-DD) | [optional]
**incoming_document_number** | **string** | Incoming external document number | [optional]
**invoice** | **string** | Invoice number | [optional]
**is_automatic** | **bool** | Automatic document creation flag | [optional]
**is_editable** | **bool** | Editable flag. true — available for editing in RMS | [optional]
**items** | [**\IIKO\Model\IncomingServiceGetItem[]**](IncomingServiceGetItem.md) | List of document items | [optional]
**number** | **string** | Document number | [optional]
**revenue_account** | **string** | Revenue account identifier (GUID) | [optional]
**status** | **string** | Document status (NEW — not processed, PROCESSED — processed, DELETED — deleted) | [optional]
**sum** | **float** | Amount including VAT | [optional]
**sum_without_vat** | **float** | Amount excluding VAT | [optional]
**user_created** | **string** | User who created the document (GUID) | [optional]
**user_modified** | **string** | User who last modified the document (GUID) | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
