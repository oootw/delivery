# IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsGetAllowedRestrictionsResponse

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**correlation_id** | **string** | Operation ID. |
**is_allowed** | **bool** | A sign of successful verification. |
**reject_cause** | **string** | Reject cause. |
**address_external_id** | **string** | Delivery address ID in external mapping system. |
**location** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesCommonCoordinates**](IikoTransportPublicApiContractsDeliveriesCommonCoordinates.md) | Coordinates returned by geocoding service. |
**allowed_items** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsAllowedItemWithDuration[]**](IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsAllowedItemWithDuration.md) | Suitable terminal groups with a delivery duration for them. |
**rejected_items** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRejectItem[]**](IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRejectItem.md) | Rejected items with cause. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
