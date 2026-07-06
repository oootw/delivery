# IncomeReceipt

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**service_name** | **string** | Описание услуги, оказанной получателем выплаты. Не более 50 символов. |
**npd_receipt_id** | **string** | Идентификатор чека в сервисе. Пример: 208jd98zqe | [optional]
**url** | **string** | Ссылка на зарегистрированный чек. Пример: https://www.nalog.gov.ru/api/v1/receipt/&lt;Идентификатор чека&gt;/print | [optional]
**amount** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Сумма, указанная в чеке. Присутствует, если в запросе передавалась сумма для печати в чеке. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
