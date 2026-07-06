# TransactionItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**account** | **string** | Account or store. string (UUID) | [optional]
**balance** | **float** | Accumulated account balance after this transaction. decimal | [optional]
**cash_flow_category** | **string** | Cash flow category. string (UUID), or null | [optional]
**cash_order_number** | **string** | Cash order number. string, or null | [optional]
**cause_event_id** | **string** | ID of the event that caused the transaction creation. string (UUID), or &#x60;null&#x60; | [optional]
**comment** | **string** | Transaction comment. string, or null | [optional]
**conception** | **string** | Concept the transaction belongs to. string (UUID), or null | [optional]
**counteragent** | **string** | Counteragent. string (UUID), or null | [optional]
**date** | **string** | Transaction accounting date and time. string (ISO 8601 YYYY-MM-DDThh:mm:ss±hh:mm) | [optional]
**date_created** | **string** | Transaction creation date. string (ISO 8601 YYYY-MM-DDThh:mm:ss±hh:mm) | [optional]
**date_modified** | **string** | Transaction last modified date. string (ISO 8601 YYYY-MM-DDThh:mm:ss±hh:mm), or null | [optional]
**date_secondary** | **string** | Secondary transaction date. string (ISO 8601 YYYY-MM-DDThh:mm:ss±hh:mm), or null | [optional]
**document_id** | **string** | Related document ID. string (UUID), or null | [optional]
**document_type** | **string** | Document type, ENUM | [optional]
**number** | **string** | Related document or cash session number. string, or null | [optional]
**penalty_or_bonus_type** | **string** | Penalty/bonus type — filled only for &#x60;PENALTY&#x60; / &#x60;BONUS&#x60; transactions. UUID, or &#x60;null&#x60; | [optional]
**second_counteragent** | **string** | Corresponding counteragent (employee/user) for the transaction. string (UUID), or &#x60;null&#x60; | [optional]
**session** | **string** | Cash session in which the transaction was created. string (UUID), or null | [optional]
**sum** | **float** | Transaction amount. decimal | [optional]
**terminal** | **string** | Terminal on which the transaction was created. string (UUID), or &#x60;null&#x60; | [optional]
**type** | **string** | Transaction type, ENUM | [optional]
**user_modified** | **string** | User who last modified the transaction. string (UUID), or null | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
