# IncomingInvoiceRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**comment** | **string** | Comment | [optional]
**conception** | **string** | Concept identifier (GUID) | [optional]
**counteragent** | **string** | Counteragent identifier (GUID) |
**date** | **string** | Document date and time (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) |
**default_store** | **string** | Default store identifier (GUID) | [optional]
**delivery_on_time** | **bool** | On-time delivery flag | [optional]
**document_id** | **string** | Document identifier (GUID) | [optional]
**due_date** | **string** | Payment due date | [optional]
**employee_pass_to_account** | **string** | Charge to employee | [optional]
**incoming_date** | **string** | Incoming document date (YYYY-MM-DD) | [optional]
**incoming_document_number** | **string** | Incoming external document number | [optional]
**internal_outgoing_invoice_id** | **string** | Associated outgoing invoice identifier (GUID) | [optional]
**invoice** | **string** | Invoice number | [optional]
**is_automatic** | **bool** | Automatic document creation flag | [optional]
**is_editable** | **bool** | Editable flag. true — available for editing in RMS | [optional]
**items** | [**\IIKO\Model\IncomingInvoiceRequestItem[]**](IncomingInvoiceRequestItem.md) | List of document items |
**number** | **string** | Document number | [optional]
**organization_id** | **string** | Organization identifier (GUID) |
**transport_invoice_number** | **string** | Transport invoice number | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
