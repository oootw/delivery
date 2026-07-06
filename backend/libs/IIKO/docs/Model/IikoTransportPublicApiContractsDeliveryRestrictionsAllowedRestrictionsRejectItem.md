# IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRejectItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**terminal_group_id** | **string** | Terminal group ID.                Can be obtained by &#x60;/api/1/terminal_groups&#x60; operation. |
**organization_id** | **string** | Organization ID.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**zone** | **string** | Delivery zone name which this TerminalGroupId belongs to. | [optional]
**reject_code** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsDeliveryRestrictionRejectCode**](IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsDeliveryRestrictionRejectCode.md) | Reject cause code. |
**reject_hint** | **string** | Reject hint. |
**reject_item_data** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRejectItemData**](IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRejectItemData.md) | Reject additional information. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
