# IikoTransportPublicApiContractsDeliveriesDraftsFilterDraftsRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_ids** | **string[]** | Organization ID for which the order drafts search will be performed.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**date_from** | **string** | Draft creation time (UTC). Lower limit. | [optional]
**date_to** | **string** | Draft creation time (UTC). Upper limit. | [optional]
**phone** | **string** | Phone number. | [optional]
**limit** | **int** | Desirable size of result set (50 by default). | [optional]
**offset** | **int** | Offset from the beginning of full result set for paging. | [optional]
**source_keys** | **string[]** | Delivery sources (DeliveryClub, PH and etc.) | [optional]
**terminal_group_ids** | **string[]** | List of terminal groups IDs. | [optional]
**search_text** | **string** | Value for search. Used for prefix search. | [optional]
**sort_property** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsOrderDraftSortProperty**](IikoTransportPublicApiContractsDeliveriesDraftsOrderDraftSortProperty.md) | Sorting property. | [optional]
**sort_direction** | [**\IIKO\Model\IikoTransportPublicApiContractsCommonSortDirection**](IikoTransportPublicApiContractsCommonSortDirection.md) | Sorting direction. | [optional]
**operator_ids** | **string[]** | List of drafts operator IDs. | [optional]
**order_type_ids** | **string[]** | List of drafts order type IDs. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
