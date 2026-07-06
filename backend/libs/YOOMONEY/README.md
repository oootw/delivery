# OpenAPIClient-php

The YooMoney API Reference describes all the YooMoney API methods. The API allows you to process online payments via different methods and make payouts. More about integration via the YooMoney API: Integration guide: https://yookassa.ru/developers: description of payment solutions based on the YooMoney API as well as links to detailed instructions.; Interaction format: https://yookassa.ru/developers/using-api/interaction-format: description of request formats, requirements for request authentication and idempotency key, specifics of response processing.; OpenAPI specification: https://yookassa.ru/developers/using-api/openapi-specification: information about the YooMoney API specification, link for downloading the specification in the YAML format.; Ready-made SDK: https://yookassa.ru/developers/using-api/using-sdks: links to ready-made solutions for PHP, Python, and other programming languages.; Incoming notifications: https://yookassa.ru/developers/using-api/webhooks: description of the operating procedure for notifications (webhook, callback) sent to track object statuses. YooMoney API changelog: https://yookassa.ru/developers/using-api/changelog


## Installation & Usage

### Requirements

PHP 8.1 and later.

### Composer

To install the bindings via [Composer](https://getcomposer.org/), add the following to `composer.json`:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/GIT_USER_ID/GIT_REPO_ID.git"
    }
  ],
  "require": {
    "GIT_USER_ID/GIT_REPO_ID": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
<?php
require_once('/path/to/OpenAPIClient-php/vendor/autoload.php');
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure OAuth2 access token for authorization: OAuth2
$config = YOOMONEY\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure HTTP basic authorization: BasicAuth
$config = YOOMONEY\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$deal_id = 'deal_id_example'; // string

try {
    $result = $apiInstance->dealsDealIdGet($deal_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->dealsDealIdGet: ', $e->getMessage(), PHP_EOL;
}

```

## API Endpoints

All URIs are relative to *https://api.yookassa.ru/v3*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*DefaultApi* | [**dealsDealIdGet**](docs/Api/DefaultApi.md#dealsdealidget) | **GET** /deals/{deal_id} | Информация о сделке
*DefaultApi* | [**dealsGet**](docs/Api/DefaultApi.md#dealsget) | **GET** /deals | Список сделок
*DefaultApi* | [**dealsPost**](docs/Api/DefaultApi.md#dealspost) | **POST** /deals | Создание сделки
*DefaultApi* | [**invoicesInvoiceIdGet**](docs/Api/DefaultApi.md#invoicesinvoiceidget) | **GET** /invoices/{invoice_id} | Информация о счете
*DefaultApi* | [**invoicesPost**](docs/Api/DefaultApi.md#invoicespost) | **POST** /invoices | Создание счета
*DefaultApi* | [**meGet**](docs/Api/DefaultApi.md#meget) | **GET** /me | Информация о настройках магазина или шлюза
*DefaultApi* | [**paymentMethodsPaymentMethodIdGet**](docs/Api/DefaultApi.md#paymentmethodspaymentmethodidget) | **GET** /payment_methods/{payment_method_id} | Информация о способе оплаты
*DefaultApi* | [**paymentMethodsPost**](docs/Api/DefaultApi.md#paymentmethodspost) | **POST** /payment_methods | Создание способа оплаты
*DefaultApi* | [**payoutsGet**](docs/Api/DefaultApi.md#payoutsget) | **GET** /payouts | List of payouts
*DefaultApi* | [**payoutsPayoutIdGet**](docs/Api/DefaultApi.md#payoutspayoutidget) | **GET** /payouts/{payout_id} | Информация о выплате
*DefaultApi* | [**payoutsPost**](docs/Api/DefaultApi.md#payoutspost) | **POST** /payouts | Создание выплаты
*DefaultApi* | [**payoutsSearchGet**](docs/Api/DefaultApi.md#payoutssearchget) | **GET** /payouts/search | Search for payouts
*DefaultApi* | [**personalDataPersonalDataIdGet**](docs/Api/DefaultApi.md#personaldatapersonaldataidget) | **GET** /personal_data/{personal_data_id} | Информация о персональных данных
*DefaultApi* | [**personalDataPost**](docs/Api/DefaultApi.md#personaldatapost) | **POST** /personal_data | Создание персональных данных
*DefaultApi* | [**posLinksPosLinkIdActivatePost**](docs/Api/DefaultApi.md#poslinksposlinkidactivatepost) | **POST** /pos_links/{pos_link_id}/activate | Активация ранее деактивированной кассовой ссылки
*DefaultApi* | [**posLinksPosLinkIdDeactivatePost**](docs/Api/DefaultApi.md#poslinksposlinkiddeactivatepost) | **POST** /pos_links/{pos_link_id}/deactivate | Деактивация кассовой ссылки
*DefaultApi* | [**posLinksPosLinkIdGet**](docs/Api/DefaultApi.md#poslinksposlinkidget) | **GET** /pos_links/{pos_link_id} | Информация о кассовой ссылке
*DefaultApi* | [**posLinksPosLinkIdRecipientPost**](docs/Api/DefaultApi.md#poslinksposlinkidrecipientpost) | **POST** /pos_links/{pos_link_id}/recipient | Изменение торговой точки, привязанной к кассовой ссылке
*DefaultApi* | [**posLinksPost**](docs/Api/DefaultApi.md#poslinkspost) | **POST** /pos_links | Активация кассовой ссылки
*DefaultApi* | [**receiptsGet**](docs/Api/DefaultApi.md#receiptsget) | **GET** /receipts | Список чеков
*DefaultApi* | [**receiptsPost**](docs/Api/DefaultApi.md#receiptspost) | **POST** /receipts | Создание чека
*DefaultApi* | [**receiptsReceiptIdGet**](docs/Api/DefaultApi.md#receiptsreceiptidget) | **GET** /receipts/{receipt_id} | Информация о чеке
*DefaultApi* | [**refundsGet**](docs/Api/DefaultApi.md#refundsget) | **GET** /refunds | Список возвратов
*DefaultApi* | [**refundsPost**](docs/Api/DefaultApi.md#refundspost) | **POST** /refunds | Создание возврата
*DefaultApi* | [**refundsRefundIdGet**](docs/Api/DefaultApi.md#refundsrefundidget) | **GET** /refunds/{refund_id} | Информация о возврате
*DefaultApi* | [**sbpBanksGet**](docs/Api/DefaultApi.md#sbpbanksget) | **GET** /sbp_banks | Список участников СБП
*PaymentsApi* | [**paymentsGet**](docs/Api/PaymentsApi.md#paymentsget) | **GET** /payments | List payments
*PaymentsApi* | [**paymentsPaymentIdCancelPost**](docs/Api/PaymentsApi.md#paymentspaymentidcancelpost) | **POST** /payments/{payment_id}/cancel | Cancel a payment
*PaymentsApi* | [**paymentsPaymentIdCapturePost**](docs/Api/PaymentsApi.md#paymentspaymentidcapturepost) | **POST** /payments/{payment_id}/capture | Capture a payment
*PaymentsApi* | [**paymentsPaymentIdGet**](docs/Api/PaymentsApi.md#paymentspaymentidget) | **GET** /payments/{payment_id} | Get payment information
*PaymentsApi* | [**paymentsPost**](docs/Api/PaymentsApi.md#paymentspost) | **POST** /payments | Create a payment
*WebhooksApi* | [**webhooksGet**](docs/Api/WebhooksApi.md#webhooksget) | **GET** /webhooks | Список созданных webhook
*WebhooksApi* | [**webhooksPost**](docs/Api/WebhooksApi.md#webhookspost) | **POST** /webhooks | Создание webhook
*WebhooksApi* | [**webhooksWebhookIdDelete**](docs/Api/WebhooksApi.md#webhookswebhookiddelete) | **DELETE** /webhooks/{webhook_id} | Удаление webhook

## Models

- [Airline](docs/Model/Airline.md)
- [AirlineLeg](docs/Model/AirlineLeg.md)
- [AirlinePassenger](docs/Model/AirlinePassenger.md)
- [AuthorizationDetails](docs/Model/AuthorizationDetails.md)
- [B2bSberbankCalculatedVatData](docs/Model/B2bSberbankCalculatedVatData.md)
- [B2bSberbankMixedVatData](docs/Model/B2bSberbankMixedVatData.md)
- [B2bSberbankPayerBankDetails](docs/Model/B2bSberbankPayerBankDetails.md)
- [B2bSberbankUntaxedVatData](docs/Model/B2bSberbankUntaxedVatData.md)
- [B2bSberbankVatData](docs/Model/B2bSberbankVatData.md)
- [B2bSberbankVatDataType](docs/Model/B2bSberbankVatDataType.md)
- [BadRequest](docs/Model/BadRequest.md)
- [BankCardData](docs/Model/BankCardData.md)
- [BankCardDataSource](docs/Model/BankCardDataSource.md)
- [BankCardProduct](docs/Model/BankCardProduct.md)
- [BankCardType](docs/Model/BankCardType.md)
- [BaseDeal](docs/Model/BaseDeal.md)
- [CapturePaymentDeal](docs/Model/CapturePaymentDeal.md)
- [CardDataForPayoutDestination](docs/Model/CardDataForPayoutDestination.md)
- [CardRequestData](docs/Model/CardRequestData.md)
- [CardRequestDataWithCsc](docs/Model/CardRequestDataWithCsc.md)
- [Confirmation](docs/Model/Confirmation.md)
- [ConfirmationData](docs/Model/ConfirmationData.md)
- [ConfirmationDataEmbedded](docs/Model/ConfirmationDataEmbedded.md)
- [ConfirmationDataExternal](docs/Model/ConfirmationDataExternal.md)
- [ConfirmationDataMobileApplication](docs/Model/ConfirmationDataMobileApplication.md)
- [ConfirmationDataQr](docs/Model/ConfirmationDataQr.md)
- [ConfirmationDataRedirect](docs/Model/ConfirmationDataRedirect.md)
- [ConfirmationDataType](docs/Model/ConfirmationDataType.md)
- [ConfirmationEmbedded](docs/Model/ConfirmationEmbedded.md)
- [ConfirmationExternal](docs/Model/ConfirmationExternal.md)
- [ConfirmationMobileApplication](docs/Model/ConfirmationMobileApplication.md)
- [ConfirmationQr](docs/Model/ConfirmationQr.md)
- [ConfirmationRedirect](docs/Model/ConfirmationRedirect.md)
- [ConfirmationType](docs/Model/ConfirmationType.md)
- [CreateInvoiceRequest](docs/Model/CreateInvoiceRequest.md)
- [CreateInvoiceRequestDeliveryMethodData](docs/Model/CreateInvoiceRequestDeliveryMethodData.md)
- [CreatePaymentRequest](docs/Model/CreatePaymentRequest.md)
- [CreatePaymentRequestConfirmation](docs/Model/CreatePaymentRequestConfirmation.md)
- [CreatePaymentRequestPaymentMethodData](docs/Model/CreatePaymentRequestPaymentMethodData.md)
- [CreatePaymentRequestReceiver](docs/Model/CreatePaymentRequestReceiver.md)
- [CreatePaymentRequestStatementsInner](docs/Model/CreatePaymentRequestStatementsInner.md)
- [CreatePosLinkRequest](docs/Model/CreatePosLinkRequest.md)
- [CreateWebhookRequest](docs/Model/CreateWebhookRequest.md)
- [CurrencyCode](docs/Model/CurrencyCode.md)
- [DealList](docs/Model/DealList.md)
- [DealStatus](docs/Model/DealStatus.md)
- [DealType](docs/Model/DealType.md)
- [DeliveryMethod](docs/Model/DeliveryMethod.md)
- [DeliveryMethodData](docs/Model/DeliveryMethodData.md)
- [DeliveryMethodDataEmail](docs/Model/DeliveryMethodDataEmail.md)
- [DeliveryMethodDataSelf](docs/Model/DeliveryMethodDataSelf.md)
- [DeliveryMethodDataSms](docs/Model/DeliveryMethodDataSms.md)
- [DeliveryMethodEmail](docs/Model/DeliveryMethodEmail.md)
- [DeliveryMethodSelf](docs/Model/DeliveryMethodSelf.md)
- [DeliveryMethodSms](docs/Model/DeliveryMethodSms.md)
- [ElectronicCertificate](docs/Model/ElectronicCertificate.md)
- [ElectronicCertificateApprovedPaymentArticle](docs/Model/ElectronicCertificateApprovedPaymentArticle.md)
- [ElectronicCertificateArticle](docs/Model/ElectronicCertificateArticle.md)
- [ElectronicCertificatePayment](docs/Model/ElectronicCertificatePayment.md)
- [ElectronicCertificatePaymentData](docs/Model/ElectronicCertificatePaymentData.md)
- [ElectronicCertificateRefundArticle](docs/Model/ElectronicCertificateRefundArticle.md)
- [ElectronicCertificateRefundDataRequest](docs/Model/ElectronicCertificateRefundDataRequest.md)
- [ElectronicCertificateRefundDataResponse](docs/Model/ElectronicCertificateRefundDataResponse.md)
- [ElectronicCertificateRefundMethod](docs/Model/ElectronicCertificateRefundMethod.md)
- [ElectronicCertificateRefundMethodData](docs/Model/ElectronicCertificateRefundMethodData.md)
- [Error](docs/Model/Error.md)
- [FeeMoment](docs/Model/FeeMoment.md)
- [FiscalizationData](docs/Model/FiscalizationData.md)
- [FiscalizationProvider](docs/Model/FiscalizationProvider.md)
- [Forbidden](docs/Model/Forbidden.md)
- [GetSbpBanksResponse](docs/Model/GetSbpBanksResponse.md)
- [Gone](docs/Model/Gone.md)
- [IncomeReceipt](docs/Model/IncomeReceipt.md)
- [IndustryDetails](docs/Model/IndustryDetails.md)
- [InternalServerError](docs/Model/InternalServerError.md)
- [InvalidCredentials](docs/Model/InvalidCredentials.md)
- [Invoice](docs/Model/Invoice.md)
- [InvoiceCancellationDetails](docs/Model/InvoiceCancellationDetails.md)
- [InvoiceDeliveryMethod](docs/Model/InvoiceDeliveryMethod.md)
- [InvoiceStatus](docs/Model/InvoiceStatus.md)
- [InvoicingBankCardData](docs/Model/InvoicingBankCardData.md)
- [LineItem](docs/Model/LineItem.md)
- [Locale](docs/Model/Locale.md)
- [MarkCodeInfo](docs/Model/MarkCodeInfo.md)
- [MarkQuantity](docs/Model/MarkQuantity.md)
- [Me](docs/Model/Me.md)
- [MonetaryAmount](docs/Model/MonetaryAmount.md)
- [NotFound](docs/Model/NotFound.md)
- [NotificationEventType](docs/Model/NotificationEventType.md)
- [OperationalDetails](docs/Model/OperationalDetails.md)
- [Payment](docs/Model/Payment.md)
- [PaymentCancellationDetails](docs/Model/PaymentCancellationDetails.md)
- [PaymentCaptureRequest](docs/Model/PaymentCaptureRequest.md)
- [PaymentConfirmation](docs/Model/PaymentConfirmation.md)
- [PaymentData](docs/Model/PaymentData.md)
- [PaymentDealInfo](docs/Model/PaymentDealInfo.md)
- [PaymentDetails](docs/Model/PaymentDetails.md)
- [PaymentInvoiceDetails](docs/Model/PaymentInvoiceDetails.md)
- [PaymentList](docs/Model/PaymentList.md)
- [PaymentMethod](docs/Model/PaymentMethod.md)
- [PaymentMethodAlfaPay](docs/Model/PaymentMethodAlfaPay.md)
- [PaymentMethodAlfabank](docs/Model/PaymentMethodAlfabank.md)
- [PaymentMethodApplePay](docs/Model/PaymentMethodApplePay.md)
- [PaymentMethodB2bSberbank](docs/Model/PaymentMethodB2bSberbank.md)
- [PaymentMethodB2bSberbankAllOfVatData](docs/Model/PaymentMethodB2bSberbankAllOfVatData.md)
- [PaymentMethodBankCard](docs/Model/PaymentMethodBankCard.md)
- [PaymentMethodCash](docs/Model/PaymentMethodCash.md)
- [PaymentMethodData](docs/Model/PaymentMethodData.md)
- [PaymentMethodDataAlfaPay](docs/Model/PaymentMethodDataAlfaPay.md)
- [PaymentMethodDataB2bSberbank](docs/Model/PaymentMethodDataB2bSberbank.md)
- [PaymentMethodDataB2bSberbankAllOfVatData](docs/Model/PaymentMethodDataB2bSberbankAllOfVatData.md)
- [PaymentMethodDataBankCard](docs/Model/PaymentMethodDataBankCard.md)
- [PaymentMethodDataCash](docs/Model/PaymentMethodDataCash.md)
- [PaymentMethodDataElectronicCertificate](docs/Model/PaymentMethodDataElectronicCertificate.md)
- [PaymentMethodDataMobileBalance](docs/Model/PaymentMethodDataMobileBalance.md)
- [PaymentMethodDataSberBnpl](docs/Model/PaymentMethodDataSberBnpl.md)
- [PaymentMethodDataSberLoan](docs/Model/PaymentMethodDataSberLoan.md)
- [PaymentMethodDataSberbank](docs/Model/PaymentMethodDataSberbank.md)
- [PaymentMethodDataSbp](docs/Model/PaymentMethodDataSbp.md)
- [PaymentMethodDataTinkoffBank](docs/Model/PaymentMethodDataTinkoffBank.md)
- [PaymentMethodDataYooMoney](docs/Model/PaymentMethodDataYooMoney.md)
- [PaymentMethodElectronicCertificate](docs/Model/PaymentMethodElectronicCertificate.md)
- [PaymentMethodGooglePay](docs/Model/PaymentMethodGooglePay.md)
- [PaymentMethodInstallments](docs/Model/PaymentMethodInstallments.md)
- [PaymentMethodMobileBalance](docs/Model/PaymentMethodMobileBalance.md)
- [PaymentMethodQiwi](docs/Model/PaymentMethodQiwi.md)
- [PaymentMethodSberBnpl](docs/Model/PaymentMethodSberBnpl.md)
- [PaymentMethodSberLoan](docs/Model/PaymentMethodSberLoan.md)
- [PaymentMethodSberbank](docs/Model/PaymentMethodSberbank.md)
- [PaymentMethodSbp](docs/Model/PaymentMethodSbp.md)
- [PaymentMethodStatus](docs/Model/PaymentMethodStatus.md)
- [PaymentMethodTinkoffBank](docs/Model/PaymentMethodTinkoffBank.md)
- [PaymentMethodType](docs/Model/PaymentMethodType.md)
- [PaymentMethodWeChat](docs/Model/PaymentMethodWeChat.md)
- [PaymentMethodWebmoney](docs/Model/PaymentMethodWebmoney.md)
- [PaymentMethodYooMoney](docs/Model/PaymentMethodYooMoney.md)
- [PaymentMethodsConfirmation](docs/Model/PaymentMethodsConfirmation.md)
- [PaymentMethodsConfirmationData](docs/Model/PaymentMethodsConfirmationData.md)
- [PaymentMethodsConfirmationDataQr](docs/Model/PaymentMethodsConfirmationDataQr.md)
- [PaymentMethodsConfirmationDataRedirect](docs/Model/PaymentMethodsConfirmationDataRedirect.md)
- [PaymentMethodsConfirmationQr](docs/Model/PaymentMethodsConfirmationQr.md)
- [PaymentMethodsConfirmationRedirect](docs/Model/PaymentMethodsConfirmationRedirect.md)
- [PaymentMethodsConfirmationType](docs/Model/PaymentMethodsConfirmationType.md)
- [PaymentMethodsPost200Response](docs/Model/PaymentMethodsPost200Response.md)
- [PaymentMethodsPostRequest](docs/Model/PaymentMethodsPostRequest.md)
- [PaymentOrderBankUtilities](docs/Model/PaymentOrderBankUtilities.md)
- [PaymentOrderData](docs/Model/PaymentOrderData.md)
- [PaymentOrderDataUtilities](docs/Model/PaymentOrderDataUtilities.md)
- [PaymentOrderRecipientUtilities](docs/Model/PaymentOrderRecipientUtilities.md)
- [PaymentOverviewStatementData](docs/Model/PaymentOverviewStatementData.md)
- [PaymentOverviewStatementDeliveryMethod](docs/Model/PaymentOverviewStatementDeliveryMethod.md)
- [PaymentOverviewStatementDeliveryMethodType](docs/Model/PaymentOverviewStatementDeliveryMethodType.md)
- [PaymentOverviewStatementEmailDeliveryMethod](docs/Model/PaymentOverviewStatementEmailDeliveryMethod.md)
- [PaymentPaymentMethod](docs/Model/PaymentPaymentMethod.md)
- [PaymentPeriod](docs/Model/PaymentPeriod.md)
- [PaymentRecipient](docs/Model/PaymentRecipient.md)
- [PaymentStatus](docs/Model/PaymentStatus.md)
- [Payout](docs/Model/Payout.md)
- [PayoutCancellationDetails](docs/Model/PayoutCancellationDetails.md)
- [PayoutCardData](docs/Model/PayoutCardData.md)
- [PayoutDeal](docs/Model/PayoutDeal.md)
- [PayoutDealInfo](docs/Model/PayoutDealInfo.md)
- [PayoutDestination](docs/Model/PayoutDestination.md)
- [PayoutDestinationData](docs/Model/PayoutDestinationData.md)
- [PayoutDestinationDataType](docs/Model/PayoutDestinationDataType.md)
- [PayoutDestinationType](docs/Model/PayoutDestinationType.md)
- [PayoutMethodType](docs/Model/PayoutMethodType.md)
- [PayoutPayoutDestination](docs/Model/PayoutPayoutDestination.md)
- [PayoutRequest](docs/Model/PayoutRequest.md)
- [PayoutRequestPayoutDestinationData](docs/Model/PayoutRequestPayoutDestinationData.md)
- [PayoutSelfEmployed](docs/Model/PayoutSelfEmployed.md)
- [PayoutSelfEmployedInfo](docs/Model/PayoutSelfEmployedInfo.md)
- [PayoutStatementRecipientPersonalDataRequest](docs/Model/PayoutStatementRecipientPersonalDataRequest.md)
- [PayoutStatus](docs/Model/PayoutStatus.md)
- [PayoutToBankCardDestinationData](docs/Model/PayoutToBankCardDestinationData.md)
- [PayoutToCardDestination](docs/Model/PayoutToCardDestination.md)
- [PayoutToSbpDestination](docs/Model/PayoutToSbpDestination.md)
- [PayoutToSbpDestinationData](docs/Model/PayoutToSbpDestinationData.md)
- [PayoutToYooMoneyDestination](docs/Model/PayoutToYooMoneyDestination.md)
- [PayoutToYooMoneyDestinationData](docs/Model/PayoutToYooMoneyDestinationData.md)
- [PayoutToYooMoneyDestinationDataAllOfAccountNumber](docs/Model/PayoutToYooMoneyDestinationDataAllOfAccountNumber.md)
- [PayoutsList](docs/Model/PayoutsList.md)
- [PayoutsPersonalData](docs/Model/PayoutsPersonalData.md)
- [PersonalData](docs/Model/PersonalData.md)
- [PersonalDataCancellationDetails](docs/Model/PersonalDataCancellationDetails.md)
- [PersonalDataPostRequest](docs/Model/PersonalDataPostRequest.md)
- [PersonalDataRequest](docs/Model/PersonalDataRequest.md)
- [PersonalDataType](docs/Model/PersonalDataType.md)
- [PosLinkData](docs/Model/PosLinkData.md)
- [PosLinkInfo](docs/Model/PosLinkInfo.md)
- [PosLinkLastPayment](docs/Model/PosLinkLastPayment.md)
- [PosLinkPaymentData](docs/Model/PosLinkPaymentData.md)
- [PosLinkStatus](docs/Model/PosLinkStatus.md)
- [PosLinkType](docs/Model/PosLinkType.md)
- [PostReceiptData](docs/Model/PostReceiptData.md)
- [PostReceiptDataItem](docs/Model/PostReceiptDataItem.md)
- [PostReceiptItemSupplierWithInn](docs/Model/PostReceiptItemSupplierWithInn.md)
- [Receipt](docs/Model/Receipt.md)
- [ReceiptAdditionalUserProps](docs/Model/ReceiptAdditionalUserProps.md)
- [ReceiptData](docs/Model/ReceiptData.md)
- [ReceiptDataCustomer](docs/Model/ReceiptDataCustomer.md)
- [ReceiptDataItem](docs/Model/ReceiptDataItem.md)
- [ReceiptItem](docs/Model/ReceiptItem.md)
- [ReceiptItemAgentType](docs/Model/ReceiptItemAgentType.md)
- [ReceiptItemMeasure](docs/Model/ReceiptItemMeasure.md)
- [ReceiptItemPaymentMode](docs/Model/ReceiptItemPaymentMode.md)
- [ReceiptItemPaymentSubject](docs/Model/ReceiptItemPaymentSubject.md)
- [ReceiptItemSupplier](docs/Model/ReceiptItemSupplier.md)
- [ReceiptItemSupplierWithInn](docs/Model/ReceiptItemSupplierWithInn.md)
- [ReceiptList](docs/Model/ReceiptList.md)
- [ReceiptRegistrationStatus](docs/Model/ReceiptRegistrationStatus.md)
- [ReceiptType](docs/Model/ReceiptType.md)
- [Receiver](docs/Model/Receiver.md)
- [ReceiverBankAccount](docs/Model/ReceiverBankAccount.md)
- [ReceiverDigitalWallet](docs/Model/ReceiverDigitalWallet.md)
- [ReceiverMobileBalance](docs/Model/ReceiverMobileBalance.md)
- [ReceiverType](docs/Model/ReceiverType.md)
- [Recipient](docs/Model/Recipient.md)
- [RecipientPosLinkRequest](docs/Model/RecipientPosLinkRequest.md)
- [Refund](docs/Model/Refund.md)
- [RefundAuthorizationDetails](docs/Model/RefundAuthorizationDetails.md)
- [RefundCancellationDetails](docs/Model/RefundCancellationDetails.md)
- [RefundDealData](docs/Model/RefundDealData.md)
- [RefundDealInfo](docs/Model/RefundDealInfo.md)
- [RefundList](docs/Model/RefundList.md)
- [RefundMethod](docs/Model/RefundMethod.md)
- [RefundMethodData](docs/Model/RefundMethodData.md)
- [RefundMethodType](docs/Model/RefundMethodType.md)
- [RefundRefundMethod](docs/Model/RefundRefundMethod.md)
- [RefundRequest](docs/Model/RefundRequest.md)
- [RefundSourcesData](docs/Model/RefundSourcesData.md)
- [RefundStatus](docs/Model/RefundStatus.md)
- [RuleViolationError](docs/Model/RuleViolationError.md)
- [SafeDeal](docs/Model/SafeDeal.md)
- [SafeDealRequest](docs/Model/SafeDealRequest.md)
- [SavePaymentMethod](docs/Model/SavePaymentMethod.md)
- [SavePaymentMethodBankCard](docs/Model/SavePaymentMethodBankCard.md)
- [SavePaymentMethodConfirmation](docs/Model/SavePaymentMethodConfirmation.md)
- [SavePaymentMethodData](docs/Model/SavePaymentMethodData.md)
- [SavePaymentMethodDataBankCard](docs/Model/SavePaymentMethodDataBankCard.md)
- [SavePaymentMethodDataConfirmation](docs/Model/SavePaymentMethodDataConfirmation.md)
- [SavePaymentMethodDataSbp](docs/Model/SavePaymentMethodDataSbp.md)
- [SavePaymentMethodHolder](docs/Model/SavePaymentMethodHolder.md)
- [SavePaymentMethodSbp](docs/Model/SavePaymentMethodSbp.md)
- [SavePaymentMethodSbpPayerBankDetails](docs/Model/SavePaymentMethodSbpPayerBankDetails.md)
- [SavePaymentMethodType](docs/Model/SavePaymentMethodType.md)
- [SbpParticipantBank](docs/Model/SbpParticipantBank.md)
- [SbpPayerBankDetails](docs/Model/SbpPayerBankDetails.md)
- [SbpPayoutRecipientPersonalDataRequest](docs/Model/SbpPayoutRecipientPersonalDataRequest.md)
- [SbpRefundMethod](docs/Model/SbpRefundMethod.md)
- [Settlement](docs/Model/Settlement.md)
- [SettlementItemType](docs/Model/SettlementItemType.md)
- [SettlementPaymentArrayInner](docs/Model/SettlementPaymentArrayInner.md)
- [SettlementPaymentItem](docs/Model/SettlementPaymentItem.md)
- [SettlementPayoutPayment](docs/Model/SettlementPayoutPayment.md)
- [SettlementPayoutRefund](docs/Model/SettlementPayoutRefund.md)
- [SettlementRefundArrayInner](docs/Model/SettlementRefundArrayInner.md)
- [SettlementRefundItem](docs/Model/SettlementRefundItem.md)
- [Statement](docs/Model/Statement.md)
- [ThreeDSecureDetails](docs/Model/ThreeDSecureDetails.md)
- [TooManyRequests](docs/Model/TooManyRequests.md)
- [Transfer](docs/Model/Transfer.md)
- [TransferAmount](docs/Model/TransferAmount.md)
- [TransferData](docs/Model/TransferData.md)
- [TransferDataCapture](docs/Model/TransferDataCapture.md)
- [TransferDataPayment](docs/Model/TransferDataPayment.md)
- [TransferStatus](docs/Model/TransferStatus.md)
- [Webhook](docs/Model/Webhook.md)
- [WebhookList](docs/Model/WebhookList.md)

## Authorization

Authentication schemes defined for the API:
### BasicAuth

- **Type**: HTTP basic authentication

### OAuth2

- **Type**: `OAuth`
- **Flow**: `implicit`
- **Authorization URL**: `https://yookassa.ru/oauth/v2/authorize`
- **Scopes**: 
    - **checkout:payments_create**: Право на создание платежей
    - **checkout:payments_capture**: Право на подтверждение платежей
    - **checkout:payments_cancel**: Право на отмену платежей
    - **checkout:payments_get**: Право на получение списка платежей
    - **checkout:refunds_create**: Право на создание возвратов
    - **checkout:refunds_get**: Право на получение списка возвратов
    - **checkout:receipts_get**: Право на получение списка возвратов
    - **checkout:get_fees**: Право на получение информации об удержанных комиссиях

## Tests

To run the tests, use:

```bash
composer install
vendor/bin/phpunit
```

## Author



## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: `1.0.0`
    - Generator version: `7.23.0`
- Build package: `org.openapitools.codegen.languages.PhpClientCodegen`
