# InvoiceCancellationDetails

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**party** | **string** | The participant of the process who made the decision to cancel the invoice. Possible values: merchant — a seller of products and services (you); yoo_money — YooMoney. |
**reason** | **string** | Reason for canceling the invoice. Possible values: invoice_canceled: invoice was canceled manually: https://yookassa.rudocs/support/merchant/invoices-to-clients/invoicing#invoicing__cancel from the Merchant Profile; invoice_expired: the invoice validity period, which you set in the expires_at parameter when creating request, has expired and there are no successful payments associated with the invoice; general_decline: the reason is not detailed, so the user should contact the initiator of cancellation for details; payment_canceled: two-stage payment was canceled via API: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-process#cancel; payment_expired_on_capture: debit period: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-process#hold for a two-stage payment has expired. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
