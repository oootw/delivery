# IikoTransportPublicApiContractsReservesReserveInfo

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Banquet/reserve ID. |
**external_number** | **string** | Banquet/reserve external number. | [optional]
**organization_id** | **string** | Organization ID.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**timestamp** | **int** | Timestamp of most recent banquet/reserve change that took place on iikoTransport server. |
**creation_status** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderCreationStatus**](IikoTransportPublicApiContractsDeliveriesResponseOrderCreationStatus.md) | Banquet/reserve creation status. In case of asynchronous creation, it allows to track the instance an banquet/reserve was validated/created in iikoFront. |
**error_info** | [**\IIKO\Model\IikoTransportPublicApiContractsErrorsErrorInfo**](IikoTransportPublicApiContractsErrorsErrorInfo.md) | Banquet/reserve creation error details.  &gt; Required only if \&quot;creationStatus\&quot;&#x3D;\&quot;Error\&quot;. | [optional]
**is_deleted** | **bool** | Banquet/reserve is deleted. |
**reserve** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesReserve**](IikoTransportPublicApiContractsReservesReserve.md) | Banquet/reserve. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
