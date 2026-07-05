# IikoNetServiceContractsApiIikoTransportCustomerCreateOrUpdateCustomerRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Customer id. | [optional]
**phone** | **string** | Customer phone. Can be null. | [optional]
**card_track** | **string** | Card track. Required if cardNumber set. Can be null. | [optional]
**card_number** | **string** | Card number. Required if cardTrack set. Can be null. | [optional]
**name** | **string** | Customer name. Can be null. | [optional]
**middle_name** | **string** | Customer middle name. Can be null. | [optional]
**sur_name** | **string** | Customer surname. Can be null. | [optional]
**birthday** | **string** | Customer birthday. | [optional]
**email** | **string** | Customer email. Can be null. | [optional]
**sex** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerIikoNetUserSex**](IikoNetServiceContractsApiIikoTransportCustomerIikoNetUserSex.md) | Customer sex.  &lt;br&gt;0 - not specified,&lt;br /&gt;1 - male,&lt;br /&gt;2 - female. | [optional]
**consent_status** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerIikoNetUserSex**](IikoNetServiceContractsApiIikoTransportCustomerIikoNetUserSex.md) | Customer consent status.  &lt;br&gt;0 - unknown,&lt;br /&gt;1 - given,&lt;br /&gt;2 - revoked. | [optional]
**should_receive_loyalty_info** | **bool** | Customer get loyalty messages (email, sms). If the parameter is not specified for new customers, the value &#39;true&#39; is used. | [optional]
**should_receive_promo_actions_info** | **bool** | Customer get promo messages (email, sms). If the parameter is not specified for new customers, the value &#39;true&#39; is used. | [optional]
**referrer_id** | **string** | Id for referrer guest. Null for old integrations, Guid.Empty - for referrer deletion. Can be null. | [optional]
**user_data** | **string** | Customer user data. Can be null. | [optional]
**is_deleted** | **bool** | Customer logical deletion flag. | [optional]
**employee_id** | **string** | Employee number or id. Can be null. | [optional]
**comment** | **string** | Customer description and additional data. Can be null. | [optional]
**nullify_empty_fields** | **bool** | If set to true, then empty string values (not null) will overwrite origin guest fields with nulls, otherwise empty fields are ignored. | [optional]
**organization_id** | **string** | Customer organization id. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
