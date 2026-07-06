# ReturnedInvoiceGetResponse

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**comment** | **string** | Comment | [optional]
**conception** | **string** | Concept identifier (GUID) | [optional]
**counteragent** | **string** | Counteragent identifier (GUID) | [optional]
**date** | **string** | Document date and time (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) | [optional]
**date_created** | **string** | Document creation date (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) | [optional]
**date_modified** | **string** | Document last modification date (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) | [optional]
**default_store** | **string** | Default store identifier (GUID) | [optional]
**document_id** | **string** | Document identifier (GUID) | [optional]
**expense_account** | **string** | Expense account identifier (GUID) | [optional]
**incoming_invoice_id** | **string** | Associated incoming invoice identifier (GUID) | [optional]
**items** | [**\IIKO\Model\ReturnedInvoiceGetItem[]**](ReturnedInvoiceGetItem.md) | List of document items | [optional]
**number** | **string** | Document number | [optional]
**status** | **string** | Document status (NEW — not processed, PROCESSED — processed, DELETED — deleted) | [optional]
**user_created** | **string** | User who created the document (GUID) | [optional]
**user_modified** | **string** | User who last modified the document (GUID) | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
