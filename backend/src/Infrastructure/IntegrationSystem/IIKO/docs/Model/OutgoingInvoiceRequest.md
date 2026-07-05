# OutgoingInvoiceRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**comment** | **string** | Comment | [optional]
**conception** | **string** | Concept identifier (GUID) | [optional]
**counteragent** | **string** | Counteragent identifier (GUID) |
**date** | **string** | Document date and time (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) |
**default_store** | **string** | Default store identifier (GUID) | [optional]
**document_id** | **string** | Document identifier (GUID) | [optional]
**due_date** | **string** | Payment due date | [optional]
**expense_account** | **string** | Expense account identifier (GUID) | [optional]
**internal_incoming_invoice_id** | **string** | Associated incoming invoice identifier (GUID) | [optional]
**is_automatic** | **bool** | Automatic document creation flag | [optional]
**is_editable** | **bool** | Editable flag. true — available for editing in RMS | [optional]
**items** | [**\IIKO\Model\OutgoingInvoiceRequestItem[]**](OutgoingInvoiceRequestItem.md) | List of document items |
**number** | **string** | Document number | [optional]
**organization_id** | **string** | Organization identifier (GUID) |
**revenue_account** | **string** | Revenue account identifier (GUID) | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
