# DocumentTransactionItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**cash_flow_category** | **string** | Cash flow category. string (UUID), or null | [optional]
**cash_order_number** | **string** | Cash order number. string, or null | [optional]
**comment** | **string** | Transaction comment. string, or null | [optional]
**conception** | **string** | Concept the transaction belongs to. string (UUID), or null | [optional]
**date** | **string** | Transaction accounting date and time. string (ISO 8601 YYYY-MM-DDThh:mm:ss±hh:mm) | [optional]
**date_created** | **string** | Transaction creation date. string (ISO 8601 YYYY-MM-DDThh:mm:ss±hh:mm) | [optional]
**date_modified** | **string** | Transaction last modified date. string (ISO 8601 YYYY-MM-DDThh:mm:ss±hh:mm), or null | [optional]
**date_secondary** | **string** | Secondary transaction date. string (ISO 8601 YYYY-MM-DDThh:mm:ss±hh:mm), or null | [optional]
**document_id** | **string** | Related document ID. string (UUID), or null | [optional]
**document_item_id** | **string** | Document item ID. string (UUID), or null | [optional]
**from** | [**\IIKO\Model\TransactionSide**](TransactionSide.md) | Transaction FROM (debit) side | [optional]
**id** | **string** | Transaction UUID. string (UUID) | [optional]
**number** | **string** | Related document or cash session number. string, or null | [optional]
**session** | **string** | Cash session in which the transaction was created. string (UUID), or null | [optional]
**sum** | **float** | Transaction amount. decimal | [optional]
**to** | [**\IIKO\Model\TransactionSide**](TransactionSide.md) | Transaction TO (credit) side | [optional]
**type** | **string** | Transaction type, ENUM | [optional]
**user_modified** | **string** | User who last modified the transaction. string (UUID), or null | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
