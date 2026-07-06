# IikoTransportPublicApiContractsDeliveriesRequestCreateOrderAddressLegacy

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**street** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderStreet**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderStreet.md) | Street.  &gt; It&#39;s required specify only \&quot;classifierId\&quot; or \&quot;id\&quot; or \&quot;name\&quot; and \&quot;city\&quot;. |
**index** | **string** | Postcode. | [optional]
**house** | **string** | House. |
**building** | **string** | Building. | [optional]
**flat** | **string** | Apartment.  &gt; In case useUaeAddressingSystem enabled max length - 100, otherwise - 10. | [optional]
**entrance** | **string** | Entrance. | [optional]
**floor** | **string** | Floor. | [optional]
**doorphone** | **string** | Intercom. | [optional]
**region_id** | **string** | Delivery area ID. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
