# IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDeliveryPoint

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**coordinates** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesCommonCoordinates**](IikoTransportPublicApiContractsDeliveriesCommonCoordinates.md) | Delivery address coordinates.  &gt; Allowed from version &#x60;7.7.3&#x60;. | [optional]
**address** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderAddress**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderAddress.md) | Order delivery address.                &gt; The use of type **City** is allowed if the parameter **addressFormatType &#x3D;&#x3D; City**.                &gt; Can be obtained by &#x60;/api/1/organizations&#x60; or &#x60;/api/1/organizations/settings&#x60; operations (&#x60;addressFormatType&#x60; parameter). | [optional]
**external_cartography_id** | **string** | Delivery location custom code in customer&#39;s API system. | [optional]
**comment** | **string** | Additional information. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
