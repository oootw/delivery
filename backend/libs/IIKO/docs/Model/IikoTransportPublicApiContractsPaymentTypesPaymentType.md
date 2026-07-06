# IikoTransportPublicApiContractsPaymentTypesPaymentType

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Payment type ID | [optional]
**code** | **string** | Payment type code | [optional]
**name** | **string** | Payment type name | [optional]
**comment** | **string** | Payment type comment | [optional]
**combinable** | **bool** | Combinability attribute | [optional]
**external_revision** | **int** | External system revision number. | [optional]
**applicable_marketing_campaigns** | **string[]** | Array of marketing campaigns associated with LoyaltyApp payment type applicable to this organization. |
**is_deleted** | **bool** | IsDeleted attribute of payment type. | [optional]
**print_cheque** | **bool** | If true, payment type is fiscal and bill will be printed. | [optional]
**payment_processing_type** | [**\IIKO\Model\IikoTransportPublicApiContractsPaymentTypesPaymentProcessingType**](IikoTransportPublicApiContractsPaymentTypesPaymentProcessingType.md) | Describes operation processing type. | [optional]
**payment_type_kind** | [**\IIKO\Model\IikoTransportPublicApiContractsPaymentTypesPaymentTypeKind**](IikoTransportPublicApiContractsPaymentTypesPaymentTypeKind.md) | Payment type category. | [optional]
**terminal_groups** | [**\IIKO\Model\IikoTransportPublicApiContractsTerminalsTerminalGroup[]**](IikoTransportPublicApiContractsTerminalsTerminalGroup.md) | Terminal groups where this payment type is available. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
