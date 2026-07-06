# ElectronicCertificate

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**certificate_id** | **string** | Идентификатор сертификата. От 20 до 30 символов. |
**tru_quantity** | **int** | Количество единиц товара, которое одобрили для оплаты по этому электронному сертификату. |
**available_compensation** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Максимально допустимая сумма, которую может покрыть электронный сертификат для оплаты одной единицы товара. Пример: сертификат может компенсировать максимум 1000 рублей для оплаты этого товара. |
**applied_compensation** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Сумма, которую одобрили для оплаты по сертификату за одну единицу товара. Пример: из 1000 рублей одобрили 500 рублей для оплаты по сертификату. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
