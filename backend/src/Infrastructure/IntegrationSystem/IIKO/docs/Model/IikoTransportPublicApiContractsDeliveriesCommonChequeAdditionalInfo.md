# IikoTransportPublicApiContractsDeliveriesCommonChequeAdditionalInfo

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**need_receipt** | **bool** | Whether paper cheque should be printed. |
**email** | **string** | Email to send cheque information or null if the cheque shouldn&#39;t be sent by email. | [optional]
**settlement_place** | **string** | Settlement place. | [optional]
**phone** | **string** | Phone to send cheque information (by sms) or null if the cheque shouldn&#39;t be sent by sms. | [optional]
**retail_address** | **string** | Retail address.   &gt; Allowed from version &#x60;9.4.6&#x60;. | [optional]
**is_internet_payment** | **bool** | Whether the settlement is an internet payment transaction.   &gt; Allowed from version &#x60;9.4.6&#x60;. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
