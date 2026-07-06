# IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryRestrictions

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_id** | **string** | Organization ID.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**delivery_geocode_service_type** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryGeocodeServiceType**](IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryGeocodeServiceType.md) | Geocoding service type. |
**delivery_regions_map_url** | **string** | Link to the map of delivery service regions. |
**default_delivery_duration_in_minutes** | **int** | General standard of delivery time. |
**default_self_service_duration_in_minutes** | **int** | Default pickup time. |
**use_same_delivery_duration** | **bool** | Indication that all delivery points in all delivery zones use common delivery time limits. |
**use_same_min_sum** | **bool** | Indication that all delivery points for all delivery zones use the total minimum order amount. |
**default_min_sum** | **float** | Total minimum order amount. |
**use_same_work_time_interval** | **bool** | Indication that all delivery points in all zones use common time limits. |
**default_from** | **int** | The beginning of the interval of the total work time for all points and delivery zones,   in minutes from the beginning of the day. |
**default_to** | **int** | End of the total work time interval for all points and delivery zones,   in minutes from the beginning of the day. |
**use_same_restrictions_on_all_week** | **bool** | Indication that all delivery points in all zones use the same schedule for all days of the week. |
**restrictions** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryRestrictionItem[]**](IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryRestrictionItem.md) | Restrictions. |
**delivery_zones** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryZone[]**](IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryZone.md) | Delivery zones. |
**reject_on_geocoding_error** | **bool** | Reject delivery if we could not geocode the address. |
**add_delivery_service_cost** | **bool** | Add shipping cost to order. |
**use_same_delivery_service_product** | **bool** | Indication that the cost is the same for all points of delivery. |
**default_delivery_service_product_id** | **string** | Link to \&quot;delivery service payment\&quot;. |
**use_external_assignation_service** | **bool** | Use external delivery distribution service. |
**front_trusts_call_center_check** | **bool** | Indication whether or not to trust on the fronts the call center mapping restrictions from the call center  if the composition of the order has not changed since the last check. If true, then trust. |
**external_assignation_service_url** | **string** | Address of external delivery distribution service. |
**require_exact_address_for_geocoding** | **bool** | Require an exact geocoding address. |
**zones_mode** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerIikoNetUserSex**](IikoNetServiceContractsApiIikoTransportCustomerIikoNetUserSex.md) | Delivery restrictions mode. |
**auto_assign_external_deliveries** | **bool** | Automatically assigned delivery method based on cartography. |
**action_on_validation_rejection** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsActionOnValidationRejection**](IikoTransportPublicApiContractsDeliveryRestrictionsActionOnValidationRejection.md) | Action on problems with auto-assignment. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
