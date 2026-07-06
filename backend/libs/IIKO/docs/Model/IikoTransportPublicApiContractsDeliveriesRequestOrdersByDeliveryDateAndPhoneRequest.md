# IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndPhoneRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**phone** | **string** | Delivery order phone number. |
**delivery_date_from** | **string** | Order delivery date (Local for delivery terminal). Lower limit.                The guaranteed order availability period is the last 7 days. To access earlier orders, use the &#x60;/api/1/deliveries/history/by_delivery_date_and_phone&#x60; method. | [optional]
**delivery_date_to** | **string** | Order delivery date (Local for delivery terminal). Upper limit. | [optional]
**organization_ids** | **string[]** | Organization ID for which an order search will be performed.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**start_revision** | **int** | Revision start number beginning from which (but not including) new/edited orders will be returned. | [optional]
**source_keys** | **string[]** | Source keys. | [optional]
**rows_count** | **int** | Maximum number of items returned.  &lt;remarks&gt;  If null, all items will be returned.  &lt;/remarks&gt; | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
