# IncomingInvoice

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
**items** | [**\IIKO\Model\IncomingInvoiceItem[]**](IncomingInvoiceItem.md) | List of document items | [optional]
**matches_to_the_order** | **bool** | Matches the order | [optional]
**number** | **string** | Document number | [optional]
**payment_date** | **string** | Payment date (YYYY-MM-DD) | [optional]
**status** | **string** | Document status (NEW — not processed, PROCESSED — processed, DELETED — deleted) | [optional]
**transport_invoice_number** | **string** | Transport invoice number | [optional]
**user_created** | **string** | User who created the document (GUID) | [optional]
**user_modified** | **string** | User who last modified the document (GUID) | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
