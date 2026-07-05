# IikoTransportPublicApiContractsOrganizationsExtendedOrganizationInfo

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**country** | **string** | Country. |
**restaurant_address** | **string** | Restaurant address. |
**latitude** | **float** | Latitude. |
**longitude** | **float** | Longitude. |
**use_uae_addressing_system** | **bool** | Regional setting \&quot;Use the UAE Addressing System\&quot;. |
**version** | **string** | RMS version. |
**currency_iso_name** | **string** | ISO currency code (for example: RUB, USD, EUR). |
**currency_minimum_denomination** | **float** | Value rounding of position. |
**country_phone_code** | **string** | Country dialing code. |
**marketing_source_required_in_delivery** | **bool** | Require mandatory marketing source input when creating a delivery. |
**default_delivery_city_id** | **string** | Default delivery city. |
**delivery_city_ids** | **string[]** | Delivery cities. |
**delivery_service_type** | [**\IIKO\Model\IikoTransportPublicApiContractsOrganizationsDeliverySettingsServiceType**](IikoTransportPublicApiContractsOrganizationsDeliverySettingsServiceType.md) | Delivery type. |
**delivery_order_payment_settings** | [**\IIKO\Model\IikoTransportPublicApiContractsOrganizationsDeliveryOrderPaymentSettings**](IikoTransportPublicApiContractsOrganizationsDeliveryOrderPaymentSettings.md) | Delivery order payment settings. | [optional]
**default_call_center_payment_type_id** | **string** | Default payment type for CallCenter. |
**order_item_comment_enabled** | **bool** | Allow text comments for order items (in all restaurant sections). |
**inn** | **string** | Restaurant&#x60;s INN (Taxpayer Identification Number). |
**address_format_type** | [**\IIKO\Model\IikoTransportPublicApiContractsOrganizationsAddressFormatType**](IikoTransportPublicApiContractsOrganizationsAddressFormatType.md) | Address format type. |
**is_confirmation_enabled** | **bool** | Determines whether to use delivery confirmation. |
**confirm_allowed_interval_in_minutes** | **int** | Confirm orders time interval. |
**is_cloud** | **bool** | Determines whether organization is hosted in iikoCloud. |
**is_anonymous_guests_allowed** | **bool** | If the store allows orders for anonymous guests, then it is not necessary to transfer  information about the guest as part of the delivery order. You can only transfer  the phone number and optionally name of the guest, which will not be stored in the guest base  and will only be used for the delivery of a current delivery order. | [optional]
**address_lookup** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressHintsAddressHintsServiceType[]**](IikoTransportPublicApiContractsAddressHintsAddressHintsServiceType.md) | Available address lookup services. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
