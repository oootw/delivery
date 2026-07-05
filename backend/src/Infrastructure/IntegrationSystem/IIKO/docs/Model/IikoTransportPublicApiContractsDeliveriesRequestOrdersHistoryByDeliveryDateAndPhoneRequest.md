# IikoTransportPublicApiContractsDeliveriesRequestOrdersHistoryByDeliveryDateAndPhoneRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**phone** | **string** | Delivery order phone number. |
**delivery_date_from** | **string** | Order delivery date (Local for delivery terminal). Lower limit.                Order details are stored for 90 days. | [optional]
**delivery_date_to** | **string** | Order delivery date (Local for delivery terminal). Upper limit.                Order details are stored for 90 days. | [optional]
**organization_ids** | **string[]** | Organization ID for which an order search will be performed.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**start_revision** | **int** | Revision start number beginning from which (but not including) orders will be returned.                &gt; Maximum revision offset to request - &#x60;3 hours&#x60;. | [optional]
**source_keys** | **string[]** | Source keys. | [optional]
**rows_count** | **int** | Maximum number of items returned.                &gt; Maximum numbers of items to request - &#x60;200&#x60;. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
