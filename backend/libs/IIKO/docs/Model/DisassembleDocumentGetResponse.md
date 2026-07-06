# DisassembleDocumentGetResponse

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**amount** | **float** | Product quantity | [optional]
**amount_unit** | **string** | Unit of measure identifier (GUID) | [optional]
**comment** | **string** | Comment | [optional]
**conception** | **string** | Concept identifier (GUID) | [optional]
**date** | **string** | Document date and time (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) | [optional]
**date_created** | **string** | Document creation date (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) | [optional]
**date_modified** | **string** | Document last modification date (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) | [optional]
**document_id** | **string** | Document identifier (GUID) | [optional]
**items** | [**\IIKO\Model\DisassembleDocumentGetItem[]**](DisassembleDocumentGetItem.md) | List of document items | [optional]
**number** | **string** | Document number | [optional]
**product** | **string** | Product identifier (GUID) | [optional]
**status** | **string** | Document status (NEW — not processed, PROCESSED — processed, DELETED — deleted) | [optional]
**store_from** | **string** | Write-off store identifier (GUID) | [optional]
**store_to** | **string** | Receipt store identifier (GUID) | [optional]
**user_created** | **string** | User who created the document (GUID) | [optional]
**user_modified** | **string** | User who last modified the document (GUID) | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
