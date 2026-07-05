# IikoTransportPublicApiContractsDeliveriesResponseOrderOrderInfo

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Delivery order ID. |
**pos_id** | **string** | POS delivery order ID. | [optional]
**external_number** | **string** | Order external number. | [optional]
**organization_id** | **string** | Organization ID.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**timestamp** | **int** | Timestamp of most recent order change that took place on iikoTransport server. |
**creation_status** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderCreationStatus**](IikoTransportPublicApiContractsDeliveriesResponseOrderCreationStatus.md) | Order creation status. In case of asynchronous creation, it allows to track the instance an order was validated/created in iikoFront. |
**error_info** | [**\IIKO\Model\IikoTransportPublicApiContractsErrorsErrorInfo**](IikoTransportPublicApiContractsErrorsErrorInfo.md) | Order creation error details.  &gt; Required only if \&quot;creationStatus\&quot;&#x3D;\&quot;Error\&quot;. | [optional]
**order** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderOrder**](IikoTransportPublicApiContractsDeliveriesResponseOrderOrder.md) | Order creation details.  &gt; Field is filled up if \&quot;creationStatus\&quot;&#x3D;\&quot;Success\&quot;. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
