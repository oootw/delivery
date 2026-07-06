# IikoTransportPublicApiContractsDeliveriesRequestCreateOrderTipsPayment

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**payment_type_kind** | **string** |  |
**tips_type_id** | **string** | Tips type ID.                Can be obtained by &#x60;/api/1/tips_types&#x60; operation. | [optional]
**sum** | **float** | Amount due. |
**payment_type_id** | **string** | Payment type.                 Can be obtained by &#x60;/api/1/payment_types&#x60; operation. |
**is_processed_externally** | **bool** | Whether payment item is processed by external payment system (made from outside). | [optional]
**payment_additional_data** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesCommonPaymentAdditionalData**](IikoTransportPublicApiContractsDeliveriesCommonPaymentAdditionalData.md) | Additional payment parameters. | [optional]
**is_fiscalized_externally** | **bool** | Whether the payment item is externally fiscalized.   &gt; Allowed from version &#x60;7.6.3&#x60;. | [optional]
**is_prepay** | **bool** | Whether the payment item is prepay. Unavailable for &#x60;paymentKindType.LoyaltyCard&#x60;.   &gt; Allowed from version &#x60;8.2.6&#x60;. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
