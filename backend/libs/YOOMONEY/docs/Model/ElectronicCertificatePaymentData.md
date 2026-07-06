# ElectronicCertificatePaymentData

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**amount** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Сумма, которую необходимо использовать по электронному сертификату, — значение totalCertAmount, которое вы получили в ФЭС НСПК в запросе на предварительное одобрение использования сертификата (Pre-Auth): https://www.nspk.ru/developer/api-fes#operation/preAuthPurchase. Сумма должна быть не больше общей суммы платежа (amount). |
**basket_id** | **string** | Идентификатор корзины покупки, сформированной в НСПК, — значение purchaseBasketId, которое вы получили в ФЭС НСПК в запросе на предварительное одобрение использования сертификата (Pre-Auth): https://www.nspk.ru/developer/api-fes#operation/preAuthPurchase. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
