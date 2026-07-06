# IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryRestrictionItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**min_sum** | **float** | The minimum order amount for a given point in a given time interval in this delivery zone. |
**terminal_group_id** | **string** | Terminal group ID.                Can be obtained by &#x60;/api/1/terminal_groups&#x60; operation. |
**organization_id** | **string** | Organization ID.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**zone** | **string** | Name of delivery zone from cartography. |
**week_map** | **int** | Days of the week. |
**from** | **int** | The time from which the point can process orders from the selected zone, in minutes from the beginning of the day. |
**to** | **int** | The maximum time at which a point can carry an order to a given zone, in minutes from the beginning of the day. |
**priority** | **int** | Priority of point in delivery zone. |
**delivery_duration_in_minutes** | **int** | Delivery duration in delivery zone. |
**delivery_service_product_id** | **string** | Link to \&quot;delivery service payment\&quot;. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
