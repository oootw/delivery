# IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoResponse

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Guest id. | [optional]
**referrer_id** | **string** | Guest referrer id. | [optional]
**name** | **string** | Guest name. Can be null. | [optional]
**surname** | **string** | Guest surname. Can be null. | [optional]
**middle_name** | **string** | Guest middle name. Can be null. | [optional]
**comment** | **string** | Guest comment. Can be null. | [optional]
**phone** | **string** | Main customer&#39;s phone. Can be null. | [optional]
**culture_name** | **string** | Guest culture name. Can be null. | [optional]
**birthday** | **string** | Guest birthday. | [optional]
**email** | **string** | Guest email. Can be null. | [optional]
**sex** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerIikoNetUserSex**](IikoNetServiceContractsApiIikoTransportCustomerIikoNetUserSex.md) | Sex.  &lt;br&gt;0 - not specified,&lt;br /&gt;1 - male,&lt;br /&gt;2 - female. | [optional]
**consent_status** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerIikoNetUserSex**](IikoNetServiceContractsApiIikoTransportCustomerIikoNetUserSex.md) | Guest consent status.  &lt;br&gt;0 - unknown,&lt;br /&gt;1 - given,&lt;br /&gt;2 - revoked. | [optional]
**anonymized** | **bool** | Guest anonymized. | [optional]
**cards** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGuestCardInfo[]**](IikoNetServiceContractsApiIikoTransportCustomerGuestCardInfo.md) | Customer&#39;s cards. | [optional]
**categories** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGuestCategoryShortInfo[]**](IikoNetServiceContractsApiIikoTransportCustomerGuestCategoryShortInfo.md) | Customer categories. | [optional]
**wallet_balances** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGuestBalanceInfo[]**](IikoNetServiceContractsApiIikoTransportCustomerGuestBalanceInfo.md) | Customer&#39;s user wallets. Contains bonus balances of different loyalty programs. | [optional]
**user_data** | **string** | Technical user data, customizable by restaurateur. Can be null. | [optional]
**should_receive_promo_actions_info** | **bool** | Customer get promo messages (email, sms). If null - unknown. | [optional]
**should_receive_loyalty_info** | **bool** | Guest should receive loyalty info. | [optional]
**should_receive_order_status_info** | **bool** | Guest should receive order status info. | [optional]
**personal_data_consent_from** | **string** | Guest personal data consent from. | [optional]
**personal_data_consent_to** | **string** | Guest personal data consent to. | [optional]
**personal_data_processing_from** | **string** | Guest personal data processing from. | [optional]
**personal_data_processing_to** | **string** | Guest personal data processing to. | [optional]
**is_deleted** | **bool** | Customer marked as deleted. | [optional]
**when_registered** | **string** | Registration date. | [optional]
**last_processed_order_date** | **string** | Last order date. | [optional]
**first_order_date** | **string** | First order date. | [optional]
**last_visited_organization_id** | **string** | Guest last visited organization id. | [optional]
**registration_organization_id** | **string** | Guest registration organization id. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
