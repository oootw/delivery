# IikoTransportPublicApiContractsDeliveriesResponseOrderPaymentItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**payment_type** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderPaymentType**](IikoTransportPublicApiContractsDeliveriesResponseOrderPaymentType.md) | Payment type.                 Can be obtained by &#x60;/api/1/payment_types&#x60; operation. |
**sum** | **float** | Amount due. |
**is_preliminary** | **bool** | Whether payment item is preliminary. |
**is_external** | **bool** | Payment item is external (created via biz.API). |
**is_processed_externally** | **bool** | Payment item is processed by external payment system. |
**is_fiscalized_externally** | **bool** | Whether the payment item is externally fiscalized.   &gt; Allowed from version &#x60;7.6.3&#x60;. | [optional]
**is_prepay** | **bool** | Whether the payment item is prepay.   &gt; Allowed from version &#x60;7.7.6&#x60;. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
