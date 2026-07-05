# IikoTransportPublicApiContractsTableOrdersRequestTableOrderCustomer

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Existing customer ID in RMS.   &gt; If null - the phone number and name is searched in database, otherwise the new customer is created in RMS. | [optional]
**name** | **string** | Name of customer.  &gt; Required if \&quot;id\&quot; &#x3D;&#x3D; null.  &gt; Not required if \&quot;id\&quot; specified. | [optional]
**surname** | **string** | Last name. | [optional]
**comment** | **string** | Comment. | [optional]
**birthdate** | **string** | Date of birth. | [optional]
**email** | **string** | Email. | [optional]
**should_receive_order_status_notifications** | **bool** | Whether customer receives order status notification messages. | [optional]
**gender** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesCommonGender**](IikoTransportPublicApiContractsDeliveriesCommonGender.md) | Gender. | [optional]
**phone** | **string** | Customer phone.  &gt; Required if \&quot;id\&quot; &#x3D;&#x3D; null.  &gt; Not required if \&quot;id\&quot; specified. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
