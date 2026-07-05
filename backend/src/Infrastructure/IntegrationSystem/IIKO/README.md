# OpenAPIClient-php

<h3>Description of common data formats:</h3><b>uuid</b> - string in UUID(universally unique identifier).<br/>Examples: <i>550e8400-e29b-41d4-a716-446655440000, b090de0b-8550-6e17-70b2-bbba152bcbd3</i><br/><br/><b>date-time</b> - date and time string in custom string format <b>yyyy-MM-dd HH:mm:ss.fff</b>.<br/>Examples: <i>2017-04-29 20:45:00.000, 2018-01-01 01:01:30.123</i>


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




$apiInstance = new IIKO\Api\AddressesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_cities_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressCitiesRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressCitiesRequest

try {
    $result = $apiInstance->api1CitiesPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_cities_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AddressesApi->api1CitiesPost: ', $e->getMessage(), PHP_EOL;
}

```

## API Endpoints

All URIs are relative to *http://localhost*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*AddressesApi* | [**api1CitiesPost**](docs/Api/AddressesApi.md#api1citiespost) | **POST** /api/1/cities | Cities.
*AddressesApi* | [**api1RegionsPost**](docs/Api/AddressesApi.md#api1regionspost) | **POST** /api/1/regions | Regions.
*AddressesApi* | [**api1StreetsByCityPost**](docs/Api/AddressesApi.md#api1streetsbycitypost) | **POST** /api/1/streets/by_city | Streets by city.
*AddressesApi* | [**api1StreetsByIdPost**](docs/Api/AddressesApi.md#api1streetsbyidpost) | **POST** /api/1/streets/by_id | Streets by id or by classifierId.
*AuthorizationApi* | [**api1AccessTokenPost**](docs/Api/AuthorizationApi.md#api1accesstokenpost) | **POST** /api/1/access_token | Retrieve session key for API user.
*AuthorizationApi* | [**apiV2AccessTokenPost**](docs/Api/AuthorizationApi.md#apiv2accesstokenpost) | **POST** /api/v2/access_token | Retrieve session key for API access (v2)
*BanquetsReservesApi* | [**api1ReserveAddItemsPost**](docs/Api/BanquetsReservesApi.md#api1reserveadditemspost) | **POST** /api/1/reserve/add_items | Add order items.
*BanquetsReservesApi* | [**api1ReserveAddPaymentsPost**](docs/Api/BanquetsReservesApi.md#api1reserveaddpaymentspost) | **POST** /api/1/reserve/add_payments | Add order payments.
*BanquetsReservesApi* | [**api1ReserveAvailableOrganizationsPost**](docs/Api/BanquetsReservesApi.md#api1reserveavailableorganizationspost) | **POST** /api/1/reserve/available_organizations | Returns all organizations of current account (determined by Authorization request header) for which banquet/reserve booking are available.
*BanquetsReservesApi* | [**api1ReserveAvailableRestaurantSectionsPost**](docs/Api/BanquetsReservesApi.md#api1reserveavailablerestaurantsectionspost) | **POST** /api/1/reserve/available_restaurant_sections | Returns all restaurant sections of specified terminal groups, for which banquet/reserve booking are available.
*BanquetsReservesApi* | [**api1ReserveAvailableTerminalGroupsPost**](docs/Api/BanquetsReservesApi.md#api1reserveavailableterminalgroupspost) | **POST** /api/1/reserve/available_terminal_groups | Returns all terminal groups of specified organizations, for which banquet/reserve booking are available.
*BanquetsReservesApi* | [**api1ReserveCancelPost**](docs/Api/BanquetsReservesApi.md#api1reservecancelpost) | **POST** /api/1/reserve/cancel | Cancel reservation due to some reason.
*BanquetsReservesApi* | [**api1ReserveChangeEstimatedStartTimePost**](docs/Api/BanquetsReservesApi.md#api1reservechangeestimatedstarttimepost) | **POST** /api/1/reserve/change_estimated_start_time | Change reserve/banquet estimated start time.
*BanquetsReservesApi* | [**api1ReserveChangeItemsPost**](docs/Api/BanquetsReservesApi.md#api1reservechangeitemspost) | **POST** /api/1/reserve/change_items | Change order items.
*BanquetsReservesApi* | [**api1ReserveChangeTablesPost**](docs/Api/BanquetsReservesApi.md#api1reservechangetablespost) | **POST** /api/1/reserve/change_tables | Change reserve/banquet tables.
*BanquetsReservesApi* | [**api1ReserveCreatePost**](docs/Api/BanquetsReservesApi.md#api1reservecreatepost) | **POST** /api/1/reserve/create | Create banquet/reserve.
*BanquetsReservesApi* | [**api1ReserveRestaurantSectionsWorkloadPost**](docs/Api/BanquetsReservesApi.md#api1reserverestaurantsectionsworkloadpost) | **POST** /api/1/reserve/restaurant_sections_workload | Returns all banquets/reserves for passed restaurant sections.
*BanquetsReservesApi* | [**api1ReserveStatusByIdPost**](docs/Api/BanquetsReservesApi.md#api1reservestatusbyidpost) | **POST** /api/1/reserve/status_by_id | Retrieve banquets/reserves statuses by IDs.
*CustomerCategoriesApi* | [**api1LoyaltyIikoCustomerCategoryAddPost**](docs/Api/CustomerCategoriesApi.md#api1loyaltyiikocustomercategoryaddpost) | **POST** /api/1/loyalty/iiko/customer_category/add | Add category for customer.
*CustomerCategoriesApi* | [**api1LoyaltyIikoCustomerCategoryPost**](docs/Api/CustomerCategoriesApi.md#api1loyaltyiikocustomercategorypost) | **POST** /api/1/loyalty/iiko/customer_category | Get customer categories.
*CustomerCategoriesApi* | [**api1LoyaltyIikoCustomerCategoryRemovePost**](docs/Api/CustomerCategoriesApi.md#api1loyaltyiikocustomercategoryremovepost) | **POST** /api/1/loyalty/iiko/customer_category/remove | Remove category for customer.
*CustomersApi* | [**api1LoyaltyIikoCustomerCardAddPost**](docs/Api/CustomersApi.md#api1loyaltyiikocustomercardaddpost) | **POST** /api/1/loyalty/iiko/customer/card/add | Add card.
*CustomersApi* | [**api1LoyaltyIikoCustomerCardRemovePost**](docs/Api/CustomersApi.md#api1loyaltyiikocustomercardremovepost) | **POST** /api/1/loyalty/iiko/customer/card/remove | Delete card.
*CustomersApi* | [**api1LoyaltyIikoCustomerCreateOrUpdatePost**](docs/Api/CustomersApi.md#api1loyaltyiikocustomercreateorupdatepost) | **POST** /api/1/loyalty/iiko/customer/create_or_update | Create or update customer.
*CustomersApi* | [**api1LoyaltyIikoCustomerInfoPost**](docs/Api/CustomersApi.md#api1loyaltyiikocustomerinfopost) | **POST** /api/1/loyalty/iiko/customer/info | Get customer info.
*CustomersApi* | [**api1LoyaltyIikoCustomerProgramAddPost**](docs/Api/CustomersApi.md#api1loyaltyiikocustomerprogramaddpost) | **POST** /api/1/loyalty/iiko/customer/program/add | Add customer to program.
*CustomersApi* | [**api1LoyaltyIikoCustomerWalletCancelHoldPost**](docs/Api/CustomersApi.md#api1loyaltyiikocustomerwalletcancelholdpost) | **POST** /api/1/loyalty/iiko/customer/wallet/cancel_hold | Cancel hold money.
*CustomersApi* | [**api1LoyaltyIikoCustomerWalletChargeoffPost**](docs/Api/CustomersApi.md#api1loyaltyiikocustomerwalletchargeoffpost) | **POST** /api/1/loyalty/iiko/customer/wallet/chargeoff | Withdraw balance.
*CustomersApi* | [**api1LoyaltyIikoCustomerWalletHoldPost**](docs/Api/CustomersApi.md#api1loyaltyiikocustomerwalletholdpost) | **POST** /api/1/loyalty/iiko/customer/wallet/hold | Hold money.
*CustomersApi* | [**api1LoyaltyIikoCustomerWalletTopupPost**](docs/Api/CustomersApi.md#api1loyaltyiikocustomerwallettopuppost) | **POST** /api/1/loyalty/iiko/customer/wallet/topup | Refill balance.
*CustomersApi* | [**api1LoyaltyIikoDeleteCustomersPost**](docs/Api/CustomersApi.md#api1loyaltyiikodeletecustomerspost) | **POST** /api/1/loyalty/iiko/delete_customers | Logical deletion of customers.
*CustomersApi* | [**api1LoyaltyIikoGetCountersPost**](docs/Api/CustomersApi.md#api1loyaltyiikogetcounterspost) | **POST** /api/1/loyalty/iiko/get_counters | Get counters.
*CustomersApi* | [**api1LoyaltyIikoRestoreCustomersPost**](docs/Api/CustomersApi.md#api1loyaltyiikorestorecustomerspost) | **POST** /api/1/loyalty/iiko/restore_customers | Logical recovery of customers.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesAddItemsPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliveriesadditemspost) | **POST** /api/1/deliveries/add_items | Add order items.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesAddPaymentsPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliveriesaddpaymentspost) | **POST** /api/1/deliveries/add_payments | Add order payments.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesCancelConfirmationPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliveriescancelconfirmationpost) | **POST** /api/1/deliveries/cancel_confirmation | Cancel delivery confirmation.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesCancelPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliveriescancelpost) | **POST** /api/1/deliveries/cancel | Cancel delivery order.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesChangeCommentPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliverieschangecommentpost) | **POST** /api/1/deliveries/change_comment | Change delivery comment.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesChangeCompleteBeforePost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliverieschangecompletebeforepost) | **POST** /api/1/deliveries/change_complete_before | Change time when client wants the order to be delivered.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesChangeDeliveryPointPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliverieschangedeliverypointpost) | **POST** /api/1/deliveries/change_delivery_point | Change order&#39;s delivery point information.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesChangeDriverInfoPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliverieschangedriverinfopost) | **POST** /api/1/deliveries/change_driver_info | Change driver info.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesChangeExternalDataPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliverieschangeexternaldatapost) | **POST** /api/1/deliveries/change_external_data | Change delivery external data.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesChangeOperatorPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliverieschangeoperatorpost) | **POST** /api/1/deliveries/change_operator | Assign/change the order operator.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesChangePaymentsPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliverieschangepaymentspost) | **POST** /api/1/deliveries/change_payments | Change order&#39;s payments.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesChangeServiceTypePost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliverieschangeservicetypepost) | **POST** /api/1/deliveries/change_service_type | Change order&#39;s delivery type.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesClosePost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliveriesclosepost) | **POST** /api/1/deliveries/close | Close order.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesConfirmPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliveriesconfirmpost) | **POST** /api/1/deliveries/confirm | Confirm delivery.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesCreatePost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliveriescreatepost) | **POST** /api/1/deliveries/create | Create delivery.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesPrintDeliveryBillPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliveriesprintdeliverybillpost) | **POST** /api/1/deliveries/print_delivery_bill | Print delivery bill.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesUpdateOrderCourierPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliveriesupdateordercourierpost) | **POST** /api/1/deliveries/update_order_courier | Update order courier.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesUpdateOrderDeliveryStatusPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliveriesupdateorderdeliverystatuspost) | **POST** /api/1/deliveries/update_order_delivery_status | Update delivery status.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesUpdateOrderPaymentsPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliveriesupdateorderpaymentspost) | **POST** /api/1/deliveries/update_order_payments | Update order payment details.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesUpdateOrderProblemPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliveriesupdateorderproblempost) | **POST** /api/1/deliveries/update_order_problem | Update order problem.
*DeliveriesCreateAndUpdateApi* | [**api1DeliveriesUpdateTrackingLinkPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1deliveriesupdatetrackinglinkpost) | **POST** /api/1/deliveries/update_tracking_link | Update tracking link of an order.
*DeliveriesCreateAndUpdateApi* | [**api1OrderPrintBillPost**](docs/Api/DeliveriesCreateAndUpdateApi.md#api1orderprintbillpost) | **POST** /api/1/order/print_bill | Print bill.
*DeliveriesRetrieveApi* | [**api1DeliveriesByDeliveryDateAndPhonePost**](docs/Api/DeliveriesRetrieveApi.md#api1deliveriesbydeliverydateandphonepost) | **POST** /api/1/deliveries/by_delivery_date_and_phone | Retrieve list of orders by telephone number, dates and revision.
*DeliveriesRetrieveApi* | [**api1DeliveriesByDeliveryDateAndSourceKeyAndFilterPost**](docs/Api/DeliveriesRetrieveApi.md#api1deliveriesbydeliverydateandsourcekeyandfilterpost) | **POST** /api/1/deliveries/by_delivery_date_and_source_key_and_filter | Search orders by search text and additional filters (date, problem, statuses and other).
*DeliveriesRetrieveApi* | [**api1DeliveriesByDeliveryDateAndStatusPost**](docs/Api/DeliveriesRetrieveApi.md#api1deliveriesbydeliverydateandstatuspost) | **POST** /api/1/deliveries/by_delivery_date_and_status | Retrieve list of orders by statuses and dates.
*DeliveriesRetrieveApi* | [**api1DeliveriesByIdPost**](docs/Api/DeliveriesRetrieveApi.md#api1deliveriesbyidpost) | **POST** /api/1/deliveries/by_id | Retrieve orders by IDs.
*DeliveriesRetrieveApi* | [**api1DeliveriesByRevisionPost**](docs/Api/DeliveriesRetrieveApi.md#api1deliveriesbyrevisionpost) | **POST** /api/1/deliveries/by_revision | Retrieve list of orders changed from the time revision was passed.
*DeliveriesRetrieveApi* | [**api1DeliveriesHistoryByDeliveryDateAndPhonePost**](docs/Api/DeliveriesRetrieveApi.md#api1deliverieshistorybydeliverydateandphonepost) | **POST** /api/1/deliveries/history/by_delivery_date_and_phone | Retrieve list of history orders by telephone number, dates and revision.
*DeliveryRestrictionsApi* | [**api1DeliveryRestrictionsAllowedPost**](docs/Api/DeliveryRestrictionsApi.md#api1deliveryrestrictionsallowedpost) | **POST** /api/1/delivery_restrictions/allowed | Get suitable terminal groups for delivery restrictions.
*DeliveryRestrictionsApi* | [**api1DeliveryRestrictionsPost**](docs/Api/DeliveryRestrictionsApi.md#api1deliveryrestrictionspost) | **POST** /api/1/delivery_restrictions | Retrieve list of delivery restrictions.
*DeprecatedApi* | [**api1DeliveriesUpdateOrderPaymentsPost**](docs/Api/DeprecatedApi.md#api1deliveriesupdateorderpaymentspost) | **POST** /api/1/deliveries/update_order_payments | Update order payment details.
*DeprecatedApi* | [**api1OrganizationsGet**](docs/Api/DeprecatedApi.md#api1organizationsget) | **GET** /api/1/organizations | Returns organizations available to api-login user.
*DictionariesApi* | [**api1CancelCausesPost**](docs/Api/DictionariesApi.md#api1cancelcausespost) | **POST** /api/1/cancel_causes | Delivery cancel causes.
*DictionariesApi* | [**api1DeliveriesOrderTypesPost**](docs/Api/DictionariesApi.md#api1deliveriesordertypespost) | **POST** /api/1/deliveries/order_types | Order types.
*DictionariesApi* | [**api1DiscountsPost**](docs/Api/DictionariesApi.md#api1discountspost) | **POST** /api/1/discounts | Discounts / surcharges.
*DictionariesApi* | [**api1PaymentTypesPost**](docs/Api/DictionariesApi.md#api1paymenttypespost) | **POST** /api/1/payment_types | Payment types.
*DictionariesApi* | [**api1RemovalTypesPost**](docs/Api/DictionariesApi.md#api1removaltypespost) | **POST** /api/1/removal_types | Removal types (reasons for deletion).
*DictionariesApi* | [**api1TipsTypesPost**](docs/Api/DictionariesApi.md#api1tipstypespost) | **POST** /api/1/tips_types | Get tips types for api-login&#x60;s rms group.
*DiscountsAndPromotionsApi* | [**api1LoyaltyIikoCalculatePost**](docs/Api/DiscountsAndPromotionsApi.md#api1loyaltyiikocalculatepost) | **POST** /api/1/loyalty/iiko/calculate | Calculate checkin.
*DiscountsAndPromotionsApi* | [**api1LoyaltyIikoCouponsBySeriesPost**](docs/Api/DiscountsAndPromotionsApi.md#api1loyaltyiikocouponsbyseriespost) | **POST** /api/1/loyalty/iiko/coupons/by_series | Get non-activated coupons
*DiscountsAndPromotionsApi* | [**api1LoyaltyIikoCouponsInfoPost**](docs/Api/DiscountsAndPromotionsApi.md#api1loyaltyiikocouponsinfopost) | **POST** /api/1/loyalty/iiko/coupons/info | Get coupon info.
*DiscountsAndPromotionsApi* | [**api1LoyaltyIikoCouponsSeriesPost**](docs/Api/DiscountsAndPromotionsApi.md#api1loyaltyiikocouponsseriespost) | **POST** /api/1/loyalty/iiko/coupons/series | Get coupon series with non-activated coupons.
*DiscountsAndPromotionsApi* | [**api1LoyaltyIikoManualConditionPost**](docs/Api/DiscountsAndPromotionsApi.md#api1loyaltyiikomanualconditionpost) | **POST** /api/1/loyalty/iiko/manual_condition | Get manual conditions.
*DiscountsAndPromotionsApi* | [**api1LoyaltyIikoProgramPost**](docs/Api/DiscountsAndPromotionsApi.md#api1loyaltyiikoprogrampost) | **POST** /api/1/loyalty/iiko/program | Get programs.
*DraftsApi* | [**api1DeliveriesDraftsByFilterPost**](docs/Api/DraftsApi.md#api1deliveriesdraftsbyfilterpost) | **POST** /api/1/deliveries/drafts/by_filter | Retrieve order drafts list by parameters.
*DraftsApi* | [**api1DeliveriesDraftsByIdPost**](docs/Api/DraftsApi.md#api1deliveriesdraftsbyidpost) | **POST** /api/1/deliveries/drafts/by_id | Retrieve order draft by ID.
*DraftsApi* | [**api1DeliveriesDraftsCommitPost**](docs/Api/DraftsApi.md#api1deliveriesdraftscommitpost) | **POST** /api/1/deliveries/drafts/commit | Admit order draft changes and send them to Front.
*DraftsApi* | [**api1DeliveriesDraftsCreatePost**](docs/Api/DraftsApi.md#api1deliveriesdraftscreatepost) | **POST** /api/1/deliveries/drafts/create | Create delivery order draft.
*DraftsApi* | [**api1DeliveriesDraftsDeletePost**](docs/Api/DraftsApi.md#api1deliveriesdraftsdeletepost) | **POST** /api/1/deliveries/drafts/delete | Delete order draft.
*DraftsApi* | [**api1DeliveriesDraftsLockPost**](docs/Api/DraftsApi.md#api1deliveriesdraftslockpost) | **POST** /api/1/deliveries/drafts/lock | Lock order draft.
*DraftsApi* | [**api1DeliveriesDraftsSavePost**](docs/Api/DraftsApi.md#api1deliveriesdraftssavepost) | **POST** /api/1/deliveries/drafts/save | Update existing delivery order draft.
*DraftsApi* | [**api1DeliveriesDraftsUnlockPost**](docs/Api/DraftsApi.md#api1deliveriesdraftsunlockpost) | **POST** /api/1/deliveries/drafts/unlock | Unlock order draft.
*EmployeesApi* | [**api1EmployeesCouriersActiveLocationByTerminalPost**](docs/Api/EmployeesApi.md#api1employeescouriersactivelocationbyterminalpost) | **POST** /api/1/employees/couriers/active_location/by_terminal | Returns list of all active (courier session is opened) courier&#39;s locations which are delivery drivers in specified   restaurant and are clocked in on specified delivery terminal.
*EmployeesApi* | [**api1EmployeesCouriersActiveLocationPost**](docs/Api/EmployeesApi.md#api1employeescouriersactivelocationpost) | **POST** /api/1/employees/couriers/active_location | Returns list of all active (courier session is opened) courier&#39;s locations which are delivery drivers   in specified restaurants.
*EmployeesApi* | [**api1EmployeesCouriersByRolePost**](docs/Api/EmployeesApi.md#api1employeescouriersbyrolepost) | **POST** /api/1/employees/couriers/by_role | Returns list of all employees which are delivery drivers in specified restaurants,   and checks whether each employee has passed role.
*EmployeesApi* | [**api1EmployeesCouriersLocationsByTimeOffsetPost**](docs/Api/EmployeesApi.md#api1employeescourierslocationsbytimeoffsetpost) | **POST** /api/1/employees/couriers/locations/by_time_offset | Method of obtaining drivers&#39; coordinates history.
*EmployeesApi* | [**api1EmployeesCouriersPost**](docs/Api/EmployeesApi.md#api1employeescourierspost) | **POST** /api/1/employees/couriers | Returns list of all employees which are delivery drivers in specified restaurants.
*EmployeesApi* | [**api1EmployeesInfoPost**](docs/Api/EmployeesApi.md#api1employeesinfopost) | **POST** /api/1/employees/info | Returns employee info.
*EmployeesApi* | [**api1EmployeesShiftClockinPost**](docs/Api/EmployeesApi.md#api1employeesshiftclockinpost) | **POST** /api/1/employees/shift/clockin | Open personal session.
*EmployeesApi* | [**api1EmployeesShiftClockoutPost**](docs/Api/EmployeesApi.md#api1employeesshiftclockoutpost) | **POST** /api/1/employees/shift/clockout | Close personal session.
*EmployeesApi* | [**api1EmployeesShiftIsOpenPost**](docs/Api/EmployeesApi.md#api1employeesshiftisopenpost) | **POST** /api/1/employees/shift/is_open | Check if personal session is open.
*EmployeesApi* | [**api1EmployeesShiftsByCourierPost**](docs/Api/EmployeesApi.md#api1employeesshiftsbycourierpost) | **POST** /api/1/employees/shifts/by_courier | Get terminal groups where employee session is opened.
*MarketingSourcesApi* | [**api1MarketingSourcesPost**](docs/Api/MarketingSourcesApi.md#api1marketingsourcespost) | **POST** /api/1/marketing_sources | Marketing sources.
*MenuApi* | [**api1ComboCalculatePost**](docs/Api/MenuApi.md#api1combocalculatepost) | **POST** /api/1/combo/calculate | Calculate combo price
*MenuApi* | [**api1ComboPost**](docs/Api/MenuApi.md#api1combopost) | **POST** /api/1/combo | Get combos info
*MenuApi* | [**api1NomenclaturePost**](docs/Api/MenuApi.md#api1nomenclaturepost) | **POST** /api/1/nomenclature | Menu.
*MenuApi* | [**api1StopListsAddPost**](docs/Api/MenuApi.md#api1stoplistsaddpost) | **POST** /api/1/stop_lists/add | Add items to out-of-stock list.  (You should have extra rights to use this method).
*MenuApi* | [**api1StopListsCheckPost**](docs/Api/MenuApi.md#api1stoplistscheckpost) | **POST** /api/1/stop_lists/check | Check items in out-of-stock list.
*MenuApi* | [**api1StopListsClearPost**](docs/Api/MenuApi.md#api1stoplistsclearpost) | **POST** /api/1/stop_lists/clear | Clear out-of-stock list.  (You should have extra rights to use this method).
*MenuApi* | [**api1StopListsPost**](docs/Api/MenuApi.md#api1stoplistspost) | **POST** /api/1/stop_lists | Out-of-stock items.
*MenuApi* | [**api1StopListsRemovePost**](docs/Api/MenuApi.md#api1stoplistsremovepost) | **POST** /api/1/stop_lists/remove | Remove items from out-of-stock list.  (You should have extra rights to use this method).
*MenuApi* | [**api2MenuByIdPost**](docs/Api/MenuApi.md#api2menubyidpost) | **POST** /api/2/menu/by_id | Retrieve external menu by ID.
*MenuApi* | [**api2MenuPost**](docs/Api/MenuApi.md#api2menupost) | **POST** /api/2/menu | External menus with price categories.
*MessagesApi* | [**api1LoyaltyIikoCheckSmsSendingPossibilityPost**](docs/Api/MessagesApi.md#api1loyaltyiikochecksmssendingpossibilitypost) | **POST** /api/1/loyalty/iiko/check_sms_sending_possibility | Check sms sending possibility.
*MessagesApi* | [**api1LoyaltyIikoCheckSmsStatusPost**](docs/Api/MessagesApi.md#api1loyaltyiikochecksmsstatuspost) | **POST** /api/1/loyalty/iiko/check_sms_status | Check SMS status.
*MessagesApi* | [**api1LoyaltyIikoMessageSendEmailPost**](docs/Api/MessagesApi.md#api1loyaltyiikomessagesendemailpost) | **POST** /api/1/loyalty/iiko/message/send_email | Send email.
*MessagesApi* | [**api1LoyaltyIikoMessageSendSmsPost**](docs/Api/MessagesApi.md#api1loyaltyiikomessagesendsmspost) | **POST** /api/1/loyalty/iiko/message/send_sms | Send sms.
*NotificationsApi* | [**api1NotificationsSendPost**](docs/Api/NotificationsApi.md#api1notificationssendpost) | **POST** /api/1/notifications/send | Send notification to external systems.
*OperationsApi* | [**api1CommandsStatusPost**](docs/Api/OperationsApi.md#api1commandsstatuspost) | **POST** /api/1/commands/status | Get status of command.
*OrdersApi* | [**api1OrderAddCustomerPost**](docs/Api/OrdersApi.md#api1orderaddcustomerpost) | **POST** /api/1/order/add_customer | Add customer to order.
*OrdersApi* | [**api1OrderAddItemsPost**](docs/Api/OrdersApi.md#api1orderadditemspost) | **POST** /api/1/order/add_items | Add order items.
*OrdersApi* | [**api1OrderAddPaymentsPost**](docs/Api/OrdersApi.md#api1orderaddpaymentspost) | **POST** /api/1/order/add_payments | Add order payments.
*OrdersApi* | [**api1OrderByIdPost**](docs/Api/OrdersApi.md#api1orderbyidpost) | **POST** /api/1/order/by_id | Retrieve orders by IDs.
*OrdersApi* | [**api1OrderByTablePost**](docs/Api/OrdersApi.md#api1orderbytablepost) | **POST** /api/1/order/by_table | Retrieve orders by tables.
*OrdersApi* | [**api1OrderCancelPost**](docs/Api/OrdersApi.md#api1ordercancelpost) | **POST** /api/1/order/cancel | Cancel the table order.
*OrdersApi* | [**api1OrderChangeExternalDataPost**](docs/Api/OrdersApi.md#api1orderchangeexternaldatapost) | **POST** /api/1/order/change_external_data | Change table order external_data.
*OrdersApi* | [**api1OrderChangePaymentsPost**](docs/Api/OrdersApi.md#api1orderchangepaymentspost) | **POST** /api/1/order/change_payments | Change table order&#39;s payments.
*OrdersApi* | [**api1OrderClosePost**](docs/Api/OrdersApi.md#api1orderclosepost) | **POST** /api/1/order/close | Close order.
*OrdersApi* | [**api1OrderCreatePost**](docs/Api/OrdersApi.md#api1ordercreatepost) | **POST** /api/1/order/create | Create order.
*OrdersApi* | [**api1OrderInitByPosOrderPost**](docs/Api/OrdersApi.md#api1orderinitbyposorderpost) | **POST** /api/1/order/init_by_posOrder | Init orders, created on POS, by POS orders.
*OrdersApi* | [**api1OrderInitByTablePost**](docs/Api/OrdersApi.md#api1orderinitbytablepost) | **POST** /api/1/order/init_by_table | Init orders, created on POS, by tables.
*OrganizationsApi* | [**api1OrganizationsPost**](docs/Api/OrganizationsApi.md#api1organizationspost) | **POST** /api/1/organizations | Returns organizations available to api-login user.
*OrganizationsApi* | [**api1OrganizationsSettingsPost**](docs/Api/OrganizationsApi.md#api1organizationssettingspost) | **POST** /api/1/organizations/settings | Returns available to api-login user organizations specified settings.
*PublicApiInvoiceProcessingAccountTransactionsApi* | [**apiFinanceV1AccountTransactionsListPost**](docs/Api/PublicApiInvoiceProcessingAccountTransactionsApi.md#apifinancev1accounttransactionslistpost) | **POST** /api/finance/v1/account_transactions/list | Get account transactions
*PublicApiInvoiceProcessingCounteragentsApi* | [**apiInventoryV1CounteragentsPost**](docs/Api/PublicApiInvoiceProcessingCounteragentsApi.md#apiinventoryv1counteragentspost) | **POST** /api/inventory/v1/counteragents | Get counteragents list
*PublicApiInvoiceProcessingDisassembleDocumentApi* | [**apiInventoryV1DisassembleDocumentCancelPost**](docs/Api/PublicApiInvoiceProcessingDisassembleDocumentApi.md#apiinventoryv1disassembledocumentcancelpost) | **POST** /api/inventory/v1/disassemble_document/cancel | Cancel disassemble document draft
*PublicApiInvoiceProcessingDisassembleDocumentApi* | [**apiInventoryV1DisassembleDocumentCreatePost**](docs/Api/PublicApiInvoiceProcessingDisassembleDocumentApi.md#apiinventoryv1disassembledocumentcreatepost) | **POST** /api/inventory/v1/disassemble_document/create | Create disassemble document
*PublicApiInvoiceProcessingDisassembleDocumentApi* | [**apiInventoryV1DisassembleDocumentGetPost**](docs/Api/PublicApiInvoiceProcessingDisassembleDocumentApi.md#apiinventoryv1disassembledocumentgetpost) | **POST** /api/inventory/v1/disassemble_document/get | Get disassemble document by identifier
*PublicApiInvoiceProcessingDisassembleDocumentApi* | [**apiInventoryV1DisassembleDocumentListPost**](docs/Api/PublicApiInvoiceProcessingDisassembleDocumentApi.md#apiinventoryv1disassembledocumentlistpost) | **POST** /api/inventory/v1/disassemble_document/list | Export disassemble documents
*PublicApiInvoiceProcessingDisassembleDocumentApi* | [**apiInventoryV1DisassembleDocumentPostPost**](docs/Api/PublicApiInvoiceProcessingDisassembleDocumentApi.md#apiinventoryv1disassembledocumentpostpost) | **POST** /api/inventory/v1/disassemble_document/post | Post disassemble document
*PublicApiInvoiceProcessingDisassembleDocumentApi* | [**apiInventoryV1DisassembleDocumentUnpostPost**](docs/Api/PublicApiInvoiceProcessingDisassembleDocumentApi.md#apiinventoryv1disassembledocumentunpostpost) | **POST** /api/inventory/v1/disassemble_document/unpost | Unpost disassemble document
*PublicApiInvoiceProcessingDisassembleDocumentApi* | [**apiInventoryV1DisassembleDocumentUpdatePost**](docs/Api/PublicApiInvoiceProcessingDisassembleDocumentApi.md#apiinventoryv1disassembledocumentupdatepost) | **POST** /api/inventory/v1/disassemble_document/update | Edit disassemble document
*PublicApiInvoiceProcessingDocumentTransactionsApi* | [**apiFinanceV1DocumentTransactionsListPost**](docs/Api/PublicApiInvoiceProcessingDocumentTransactionsApi.md#apifinancev1documenttransactionslistpost) | **POST** /api/finance/v1/document_transactions/list | Get document transactions
*PublicApiInvoiceProcessingIncomingInvoicesApi* | [**apiInventoryV1IncomingInvoiceCancelPost**](docs/Api/PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiinventoryv1incominginvoicecancelpost) | **POST** /api/inventory/v1/incoming_invoice/cancel | Cancel incoming invoice draft
*PublicApiInvoiceProcessingIncomingInvoicesApi* | [**apiInventoryV1IncomingInvoiceCreatePost**](docs/Api/PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiinventoryv1incominginvoicecreatepost) | **POST** /api/inventory/v1/incoming_invoice/create | Create incoming invoice
*PublicApiInvoiceProcessingIncomingInvoicesApi* | [**apiInventoryV1IncomingInvoiceGetPost**](docs/Api/PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiinventoryv1incominginvoicegetpost) | **POST** /api/inventory/v1/incoming_invoice/get | Get incoming invoice by identifier
*PublicApiInvoiceProcessingIncomingInvoicesApi* | [**apiInventoryV1IncomingInvoiceListPost**](docs/Api/PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiinventoryv1incominginvoicelistpost) | **POST** /api/inventory/v1/incoming_invoice/list | Export incoming invoices
*PublicApiInvoiceProcessingIncomingInvoicesApi* | [**apiInventoryV1IncomingInvoiceModifyAddPaymentPost**](docs/Api/PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiinventoryv1incominginvoicemodifyaddpaymentpost) | **POST** /api/inventory/v1/incoming_invoice/modify/add_payment | Pay incoming invoice
*PublicApiInvoiceProcessingIncomingInvoicesApi* | [**apiInventoryV1IncomingInvoicePatchSetPaymentDatePost**](docs/Api/PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiinventoryv1incominginvoicepatchsetpaymentdatepost) | **POST** /api/inventory/v1/incoming_invoice/patch/set_payment_date | Set payment date for incoming invoice
*PublicApiInvoiceProcessingIncomingInvoicesApi* | [**apiInventoryV1IncomingInvoicePostPost**](docs/Api/PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiinventoryv1incominginvoicepostpost) | **POST** /api/inventory/v1/incoming_invoice/post | Post incoming invoice
*PublicApiInvoiceProcessingIncomingInvoicesApi* | [**apiInventoryV1IncomingInvoiceUnpostPost**](docs/Api/PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiinventoryv1incominginvoiceunpostpost) | **POST** /api/inventory/v1/incoming_invoice/unpost | Unpost incoming invoice
*PublicApiInvoiceProcessingIncomingInvoicesApi* | [**apiInventoryV1IncomingInvoiceUpdatePost**](docs/Api/PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiinventoryv1incominginvoiceupdatepost) | **POST** /api/inventory/v1/incoming_invoice/update | Edit incoming invoice
*PublicApiInvoiceProcessingIncomingServiceApi* | [**apiFinanceV1IncomingServiceCancelPost**](docs/Api/PublicApiInvoiceProcessingIncomingServiceApi.md#apifinancev1incomingservicecancelpost) | **POST** /api/finance/v1/incoming_service/cancel | Cancel incoming service act draft
*PublicApiInvoiceProcessingIncomingServiceApi* | [**apiFinanceV1IncomingServiceCreatePost**](docs/Api/PublicApiInvoiceProcessingIncomingServiceApi.md#apifinancev1incomingservicecreatepost) | **POST** /api/finance/v1/incoming_service/create | Create incoming service act
*PublicApiInvoiceProcessingIncomingServiceApi* | [**apiFinanceV1IncomingServiceGetPost**](docs/Api/PublicApiInvoiceProcessingIncomingServiceApi.md#apifinancev1incomingservicegetpost) | **POST** /api/finance/v1/incoming_service/get | Get incoming service act
*PublicApiInvoiceProcessingIncomingServiceApi* | [**apiFinanceV1IncomingServiceListPost**](docs/Api/PublicApiInvoiceProcessingIncomingServiceApi.md#apifinancev1incomingservicelistpost) | **POST** /api/finance/v1/incoming_service/list | Export incoming service acts
*PublicApiInvoiceProcessingIncomingServiceApi* | [**apiFinanceV1IncomingServicePostPost**](docs/Api/PublicApiInvoiceProcessingIncomingServiceApi.md#apifinancev1incomingservicepostpost) | **POST** /api/finance/v1/incoming_service/post | Post incoming service act
*PublicApiInvoiceProcessingIncomingServiceApi* | [**apiFinanceV1IncomingServiceUnpostPost**](docs/Api/PublicApiInvoiceProcessingIncomingServiceApi.md#apifinancev1incomingserviceunpostpost) | **POST** /api/finance/v1/incoming_service/unpost | Unpost incoming service act
*PublicApiInvoiceProcessingIncomingServiceApi* | [**apiFinanceV1IncomingServiceUpdatePost**](docs/Api/PublicApiInvoiceProcessingIncomingServiceApi.md#apifinancev1incomingserviceupdatepost) | **POST** /api/finance/v1/incoming_service/update | Edit incoming service act
*PublicApiInvoiceProcessingInternalTransferApi* | [**apiInventoryV1InternalTransferCancelPost**](docs/Api/PublicApiInvoiceProcessingInternalTransferApi.md#apiinventoryv1internaltransfercancelpost) | **POST** /api/inventory/v1/internal_transfer/cancel | Cancel internal transfer act draft
*PublicApiInvoiceProcessingInternalTransferApi* | [**apiInventoryV1InternalTransferCreatePost**](docs/Api/PublicApiInvoiceProcessingInternalTransferApi.md#apiinventoryv1internaltransfercreatepost) | **POST** /api/inventory/v1/internal_transfer/create | Create internal transfer act
*PublicApiInvoiceProcessingInternalTransferApi* | [**apiInventoryV1InternalTransferGetPost**](docs/Api/PublicApiInvoiceProcessingInternalTransferApi.md#apiinventoryv1internaltransfergetpost) | **POST** /api/inventory/v1/internal_transfer/get | Get internal transfer act by identifier
*PublicApiInvoiceProcessingInternalTransferApi* | [**apiInventoryV1InternalTransferListPost**](docs/Api/PublicApiInvoiceProcessingInternalTransferApi.md#apiinventoryv1internaltransferlistpost) | **POST** /api/inventory/v1/internal_transfer/list | Export internal transfer acts
*PublicApiInvoiceProcessingInternalTransferApi* | [**apiInventoryV1InternalTransferPostPost**](docs/Api/PublicApiInvoiceProcessingInternalTransferApi.md#apiinventoryv1internaltransferpostpost) | **POST** /api/inventory/v1/internal_transfer/post | Post internal transfer act
*PublicApiInvoiceProcessingInternalTransferApi* | [**apiInventoryV1InternalTransferUnpostPost**](docs/Api/PublicApiInvoiceProcessingInternalTransferApi.md#apiinventoryv1internaltransferunpostpost) | **POST** /api/inventory/v1/internal_transfer/unpost | Unpost internal transfer act
*PublicApiInvoiceProcessingInternalTransferApi* | [**apiInventoryV1InternalTransferUpdatePost**](docs/Api/PublicApiInvoiceProcessingInternalTransferApi.md#apiinventoryv1internaltransferupdatepost) | **POST** /api/inventory/v1/internal_transfer/update | Edit internal transfer act
*PublicApiInvoiceProcessingNomenclatureApi* | [**apiInventoryV1NomenclatureUpdateBarcodesPost**](docs/Api/PublicApiInvoiceProcessingNomenclatureApi.md#apiinventoryv1nomenclatureupdatebarcodespost) | **POST** /api/inventory/v1/nomenclature/update_barcodes | Update product barcodes
*PublicApiInvoiceProcessingOutgoingInvoicesApi* | [**apiInventoryV1CostingsCalculatePost**](docs/Api/PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiinventoryv1costingscalculatepost) | **POST** /api/inventory/v1/costings/calculate | Get cost prices for nomenclature items
*PublicApiInvoiceProcessingOutgoingInvoicesApi* | [**apiInventoryV1OutgoingInvoiceCancelPost**](docs/Api/PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiinventoryv1outgoinginvoicecancelpost) | **POST** /api/inventory/v1/outgoing_invoice/cancel | Cancel outgoing invoice draft
*PublicApiInvoiceProcessingOutgoingInvoicesApi* | [**apiInventoryV1OutgoingInvoiceCreatePost**](docs/Api/PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiinventoryv1outgoinginvoicecreatepost) | **POST** /api/inventory/v1/outgoing_invoice/create | Create outgoing invoice
*PublicApiInvoiceProcessingOutgoingInvoicesApi* | [**apiInventoryV1OutgoingInvoiceGetPost**](docs/Api/PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiinventoryv1outgoinginvoicegetpost) | **POST** /api/inventory/v1/outgoing_invoice/get | Get outgoing invoice by ID
*PublicApiInvoiceProcessingOutgoingInvoicesApi* | [**apiInventoryV1OutgoingInvoiceListPost**](docs/Api/PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiinventoryv1outgoinginvoicelistpost) | **POST** /api/inventory/v1/outgoing_invoice/list | Export outgoing invoices
*PublicApiInvoiceProcessingOutgoingInvoicesApi* | [**apiInventoryV1OutgoingInvoiceModifyAddPaymentPost**](docs/Api/PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiinventoryv1outgoinginvoicemodifyaddpaymentpost) | **POST** /api/inventory/v1/outgoing_invoice/modify/add_payment | Pay outgoing invoice
*PublicApiInvoiceProcessingOutgoingInvoicesApi* | [**apiInventoryV1OutgoingInvoicePatchSetPaymentDatePost**](docs/Api/PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiinventoryv1outgoinginvoicepatchsetpaymentdatepost) | **POST** /api/inventory/v1/outgoing_invoice/patch/set_payment_date | Set payment date for outgoing invoice
*PublicApiInvoiceProcessingOutgoingInvoicesApi* | [**apiInventoryV1OutgoingInvoicePostPost**](docs/Api/PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiinventoryv1outgoinginvoicepostpost) | **POST** /api/inventory/v1/outgoing_invoice/post | Post outgoing invoice
*PublicApiInvoiceProcessingOutgoingInvoicesApi* | [**apiInventoryV1OutgoingInvoiceUnpostPost**](docs/Api/PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiinventoryv1outgoinginvoiceunpostpost) | **POST** /api/inventory/v1/outgoing_invoice/unpost | Unpost outgoing invoice
*PublicApiInvoiceProcessingOutgoingInvoicesApi* | [**apiInventoryV1OutgoingInvoiceUpdatePost**](docs/Api/PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiinventoryv1outgoinginvoiceupdatepost) | **POST** /api/inventory/v1/outgoing_invoice/update | Edit outgoing invoice
*PublicApiInvoiceProcessingOutgoingServiceApi* | [**apiFinanceV1OutgoingServiceCancelPost**](docs/Api/PublicApiInvoiceProcessingOutgoingServiceApi.md#apifinancev1outgoingservicecancelpost) | **POST** /api/finance/v1/outgoing_service/cancel | Cancel outgoing service act draft
*PublicApiInvoiceProcessingOutgoingServiceApi* | [**apiFinanceV1OutgoingServiceCreatePost**](docs/Api/PublicApiInvoiceProcessingOutgoingServiceApi.md#apifinancev1outgoingservicecreatepost) | **POST** /api/finance/v1/outgoing_service/create | Create outgoing service act
*PublicApiInvoiceProcessingOutgoingServiceApi* | [**apiFinanceV1OutgoingServiceGetPost**](docs/Api/PublicApiInvoiceProcessingOutgoingServiceApi.md#apifinancev1outgoingservicegetpost) | **POST** /api/finance/v1/outgoing_service/get | Get outgoing service act
*PublicApiInvoiceProcessingOutgoingServiceApi* | [**apiFinanceV1OutgoingServiceListPost**](docs/Api/PublicApiInvoiceProcessingOutgoingServiceApi.md#apifinancev1outgoingservicelistpost) | **POST** /api/finance/v1/outgoing_service/list | Export outgoing service acts
*PublicApiInvoiceProcessingOutgoingServiceApi* | [**apiFinanceV1OutgoingServicePostPost**](docs/Api/PublicApiInvoiceProcessingOutgoingServiceApi.md#apifinancev1outgoingservicepostpost) | **POST** /api/finance/v1/outgoing_service/post | Post outgoing service act
*PublicApiInvoiceProcessingOutgoingServiceApi* | [**apiFinanceV1OutgoingServiceUnpostPost**](docs/Api/PublicApiInvoiceProcessingOutgoingServiceApi.md#apifinancev1outgoingserviceunpostpost) | **POST** /api/finance/v1/outgoing_service/unpost | Unpost outgoing service act
*PublicApiInvoiceProcessingOutgoingServiceApi* | [**apiFinanceV1OutgoingServiceUpdatePost**](docs/Api/PublicApiInvoiceProcessingOutgoingServiceApi.md#apifinancev1outgoingserviceupdatepost) | **POST** /api/finance/v1/outgoing_service/update | Edit outgoing service act
*PublicApiInvoiceProcessingProductionDocumentApi* | [**apiInventoryV1ProductionDocumentCancelPost**](docs/Api/PublicApiInvoiceProcessingProductionDocumentApi.md#apiinventoryv1productiondocumentcancelpost) | **POST** /api/inventory/v1/production_document/cancel | Cancel production document draft
*PublicApiInvoiceProcessingProductionDocumentApi* | [**apiInventoryV1ProductionDocumentCreatePost**](docs/Api/PublicApiInvoiceProcessingProductionDocumentApi.md#apiinventoryv1productiondocumentcreatepost) | **POST** /api/inventory/v1/production_document/create | Create production document
*PublicApiInvoiceProcessingProductionDocumentApi* | [**apiInventoryV1ProductionDocumentGetPost**](docs/Api/PublicApiInvoiceProcessingProductionDocumentApi.md#apiinventoryv1productiondocumentgetpost) | **POST** /api/inventory/v1/production_document/get | Get production document
*PublicApiInvoiceProcessingProductionDocumentApi* | [**apiInventoryV1ProductionDocumentListPost**](docs/Api/PublicApiInvoiceProcessingProductionDocumentApi.md#apiinventoryv1productiondocumentlistpost) | **POST** /api/inventory/v1/production_document/list | Export production documents
*PublicApiInvoiceProcessingProductionDocumentApi* | [**apiInventoryV1ProductionDocumentPostPost**](docs/Api/PublicApiInvoiceProcessingProductionDocumentApi.md#apiinventoryv1productiondocumentpostpost) | **POST** /api/inventory/v1/production_document/post | Post production document
*PublicApiInvoiceProcessingProductionDocumentApi* | [**apiInventoryV1ProductionDocumentUnpostPost**](docs/Api/PublicApiInvoiceProcessingProductionDocumentApi.md#apiinventoryv1productiondocumentunpostpost) | **POST** /api/inventory/v1/production_document/unpost | Unpost production document
*PublicApiInvoiceProcessingProductionDocumentApi* | [**apiInventoryV1ProductionDocumentUpdatePost**](docs/Api/PublicApiInvoiceProcessingProductionDocumentApi.md#apiinventoryv1productiondocumentupdatepost) | **POST** /api/inventory/v1/production_document/update | Edit production document
*PublicApiInvoiceProcessingReturnedInvoiceApi* | [**apiInventoryV1ReturnedInvoiceCancelPost**](docs/Api/PublicApiInvoiceProcessingReturnedInvoiceApi.md#apiinventoryv1returnedinvoicecancelpost) | **POST** /api/inventory/v1/returned_invoice/cancel | Cancel returned invoice draft
*PublicApiInvoiceProcessingReturnedInvoiceApi* | [**apiInventoryV1ReturnedInvoiceCreatePost**](docs/Api/PublicApiInvoiceProcessingReturnedInvoiceApi.md#apiinventoryv1returnedinvoicecreatepost) | **POST** /api/inventory/v1/returned_invoice/create | Create returned invoice
*PublicApiInvoiceProcessingReturnedInvoiceApi* | [**apiInventoryV1ReturnedInvoiceGetPost**](docs/Api/PublicApiInvoiceProcessingReturnedInvoiceApi.md#apiinventoryv1returnedinvoicegetpost) | **POST** /api/inventory/v1/returned_invoice/get | Get returned invoice by identifier
*PublicApiInvoiceProcessingReturnedInvoiceApi* | [**apiInventoryV1ReturnedInvoiceListPost**](docs/Api/PublicApiInvoiceProcessingReturnedInvoiceApi.md#apiinventoryv1returnedinvoicelistpost) | **POST** /api/inventory/v1/returned_invoice/list | Export returned invoices
*PublicApiInvoiceProcessingReturnedInvoiceApi* | [**apiInventoryV1ReturnedInvoicePostPost**](docs/Api/PublicApiInvoiceProcessingReturnedInvoiceApi.md#apiinventoryv1returnedinvoicepostpost) | **POST** /api/inventory/v1/returned_invoice/post | Post returned invoice
*PublicApiInvoiceProcessingReturnedInvoiceApi* | [**apiInventoryV1ReturnedInvoiceUnpostPost**](docs/Api/PublicApiInvoiceProcessingReturnedInvoiceApi.md#apiinventoryv1returnedinvoiceunpostpost) | **POST** /api/inventory/v1/returned_invoice/unpost | Unpost returned invoice
*PublicApiInvoiceProcessingReturnedInvoiceApi* | [**apiInventoryV1ReturnedInvoiceUpdatePost**](docs/Api/PublicApiInvoiceProcessingReturnedInvoiceApi.md#apiinventoryv1returnedinvoiceupdatepost) | **POST** /api/inventory/v1/returned_invoice/update | Edit returned invoice
*PublicApiInvoiceProcessingSalesDocumentApi* | [**apiInventoryV1SalesDocumentCancelPost**](docs/Api/PublicApiInvoiceProcessingSalesDocumentApi.md#apiinventoryv1salesdocumentcancelpost) | **POST** /api/inventory/v1/sales_document/cancel | Cancel sales document draft
*PublicApiInvoiceProcessingSalesDocumentApi* | [**apiInventoryV1SalesDocumentCreatePost**](docs/Api/PublicApiInvoiceProcessingSalesDocumentApi.md#apiinventoryv1salesdocumentcreatepost) | **POST** /api/inventory/v1/sales_document/create | Create sales document
*PublicApiInvoiceProcessingSalesDocumentApi* | [**apiInventoryV1SalesDocumentGetPost**](docs/Api/PublicApiInvoiceProcessingSalesDocumentApi.md#apiinventoryv1salesdocumentgetpost) | **POST** /api/inventory/v1/sales_document/get | Get sales document
*PublicApiInvoiceProcessingSalesDocumentApi* | [**apiInventoryV1SalesDocumentListPost**](docs/Api/PublicApiInvoiceProcessingSalesDocumentApi.md#apiinventoryv1salesdocumentlistpost) | **POST** /api/inventory/v1/sales_document/list | Export sales documents
*PublicApiInvoiceProcessingSalesDocumentApi* | [**apiInventoryV1SalesDocumentPostPost**](docs/Api/PublicApiInvoiceProcessingSalesDocumentApi.md#apiinventoryv1salesdocumentpostpost) | **POST** /api/inventory/v1/sales_document/post | Post sales document
*PublicApiInvoiceProcessingSalesDocumentApi* | [**apiInventoryV1SalesDocumentUnpostPost**](docs/Api/PublicApiInvoiceProcessingSalesDocumentApi.md#apiinventoryv1salesdocumentunpostpost) | **POST** /api/inventory/v1/sales_document/unpost | Unpost sales document
*PublicApiInvoiceProcessingSalesDocumentApi* | [**apiInventoryV1SalesDocumentUpdatePost**](docs/Api/PublicApiInvoiceProcessingSalesDocumentApi.md#apiinventoryv1salesdocumentupdatepost) | **POST** /api/inventory/v1/sales_document/update | Edit sales document
*PublicApiInvoiceProcessingTransformationDocumentApi* | [**apiInventoryV1TransformationDocumentCancelPost**](docs/Api/PublicApiInvoiceProcessingTransformationDocumentApi.md#apiinventoryv1transformationdocumentcancelpost) | **POST** /api/inventory/v1/transformation_document/cancel | Cancel transformation document draft
*PublicApiInvoiceProcessingTransformationDocumentApi* | [**apiInventoryV1TransformationDocumentCreatePost**](docs/Api/PublicApiInvoiceProcessingTransformationDocumentApi.md#apiinventoryv1transformationdocumentcreatepost) | **POST** /api/inventory/v1/transformation_document/create | Create transformation document
*PublicApiInvoiceProcessingTransformationDocumentApi* | [**apiInventoryV1TransformationDocumentGetPost**](docs/Api/PublicApiInvoiceProcessingTransformationDocumentApi.md#apiinventoryv1transformationdocumentgetpost) | **POST** /api/inventory/v1/transformation_document/get | Get transformation document
*PublicApiInvoiceProcessingTransformationDocumentApi* | [**apiInventoryV1TransformationDocumentListPost**](docs/Api/PublicApiInvoiceProcessingTransformationDocumentApi.md#apiinventoryv1transformationdocumentlistpost) | **POST** /api/inventory/v1/transformation_document/list | List transformation documents
*PublicApiInvoiceProcessingTransformationDocumentApi* | [**apiInventoryV1TransformationDocumentPostPost**](docs/Api/PublicApiInvoiceProcessingTransformationDocumentApi.md#apiinventoryv1transformationdocumentpostpost) | **POST** /api/inventory/v1/transformation_document/post | Post transformation document
*PublicApiInvoiceProcessingTransformationDocumentApi* | [**apiInventoryV1TransformationDocumentUnpostPost**](docs/Api/PublicApiInvoiceProcessingTransformationDocumentApi.md#apiinventoryv1transformationdocumentunpostpost) | **POST** /api/inventory/v1/transformation_document/unpost | Unpost transformation document
*PublicApiInvoiceProcessingTransformationDocumentApi* | [**apiInventoryV1TransformationDocumentUpdatePost**](docs/Api/PublicApiInvoiceProcessingTransformationDocumentApi.md#apiinventoryv1transformationdocumentupdatepost) | **POST** /api/inventory/v1/transformation_document/update | Edit transformation document
*PublicApiInvoiceProcessingWriteoffDocumentApi* | [**apiInventoryV1WriteoffDocumentCancelPost**](docs/Api/PublicApiInvoiceProcessingWriteoffDocumentApi.md#apiinventoryv1writeoffdocumentcancelpost) | **POST** /api/inventory/v1/writeoff_document/cancel | Cancel write-off document draft
*PublicApiInvoiceProcessingWriteoffDocumentApi* | [**apiInventoryV1WriteoffDocumentCreatePost**](docs/Api/PublicApiInvoiceProcessingWriteoffDocumentApi.md#apiinventoryv1writeoffdocumentcreatepost) | **POST** /api/inventory/v1/writeoff_document/create | Create write-off document
*PublicApiInvoiceProcessingWriteoffDocumentApi* | [**apiInventoryV1WriteoffDocumentGetPost**](docs/Api/PublicApiInvoiceProcessingWriteoffDocumentApi.md#apiinventoryv1writeoffdocumentgetpost) | **POST** /api/inventory/v1/writeoff_document/get | Get write-off document by identifier
*PublicApiInvoiceProcessingWriteoffDocumentApi* | [**apiInventoryV1WriteoffDocumentListPost**](docs/Api/PublicApiInvoiceProcessingWriteoffDocumentApi.md#apiinventoryv1writeoffdocumentlistpost) | **POST** /api/inventory/v1/writeoff_document/list | Export write-off documents
*PublicApiInvoiceProcessingWriteoffDocumentApi* | [**apiInventoryV1WriteoffDocumentPostPost**](docs/Api/PublicApiInvoiceProcessingWriteoffDocumentApi.md#apiinventoryv1writeoffdocumentpostpost) | **POST** /api/inventory/v1/writeoff_document/post | Post write-off document
*PublicApiInvoiceProcessingWriteoffDocumentApi* | [**apiInventoryV1WriteoffDocumentUnpostPost**](docs/Api/PublicApiInvoiceProcessingWriteoffDocumentApi.md#apiinventoryv1writeoffdocumentunpostpost) | **POST** /api/inventory/v1/writeoff_document/unpost | Unpost write-off document
*PublicApiInvoiceProcessingWriteoffDocumentApi* | [**apiInventoryV1WriteoffDocumentUpdatePost**](docs/Api/PublicApiInvoiceProcessingWriteoffDocumentApi.md#apiinventoryv1writeoffdocumentupdatepost) | **POST** /api/inventory/v1/writeoff_document/update | Edit write-off document
*ReportApi* | [**api1LoyaltyIikoCustomerTransactionsByDatePost**](docs/Api/ReportApi.md#api1loyaltyiikocustomertransactionsbydatepost) | **POST** /api/1/loyalty/iiko/customer/transactions/by_date | Get transaction report by period.
*ReportApi* | [**api1LoyaltyIikoCustomerTransactionsByRevisionPost**](docs/Api/ReportApi.md#api1loyaltyiikocustomertransactionsbyrevisionpost) | **POST** /api/1/loyalty/iiko/customer/transactions/by_revision | Get transaction report by revision.
*TerminalGroupsApi* | [**api1TerminalGroupsAwakePost**](docs/Api/TerminalGroupsApi.md#api1terminalgroupsawakepost) | **POST** /api/1/terminal_groups/awake | Awake terminal groups from sleep mode.
*TerminalGroupsApi* | [**api1TerminalGroupsIsAlivePost**](docs/Api/TerminalGroupsApi.md#api1terminalgroupsisalivepost) | **POST** /api/1/terminal_groups/is_alive | Returns information on availability of group of terminals.
*TerminalGroupsApi* | [**api1TerminalGroupsPost**](docs/Api/TerminalGroupsApi.md#api1terminalgroupspost) | **POST** /api/1/terminal_groups | Method that returns information on groups of delivery terminals.
*WebhooksApi* | [**api1WebhooksSettingsPost**](docs/Api/WebhooksApi.md#api1webhookssettingspost) | **POST** /api/1/webhooks/settings | Get webhooks settings for specified organization and authorized API login.
*WebhooksApi* | [**api1WebhooksUpdateSettingsPost**](docs/Api/WebhooksApi.md#api1webhooksupdatesettingspost) | **POST** /api/1/webhooks/update_settings | Update webhooks settings for specified organization and authorized API login.

## Models

- [AccountTransactionsListRequest](docs/Model/AccountTransactionsListRequest.md)
- [AccountTransactionsResponse](docs/Model/AccountTransactionsResponse.md)
- [AccountingTransactionUserResponse](docs/Model/AccountingTransactionUserResponse.md)
- [AllergenGroupDto](docs/Model/AllergenGroupDto.md)
- [AllergenGroupDto2](docs/Model/AllergenGroupDto2.md)
- [AllergenGroupDto3](docs/Model/AllergenGroupDto3.md)
- [AllergenGroupDto4](docs/Model/AllergenGroupDto4.md)
- [Api2MenuByIdPost200Response](docs/Model/Api2MenuByIdPost200Response.md)
- [BarcodeDto](docs/Model/BarcodeDto.md)
- [BarcodeDto2](docs/Model/BarcodeDto2.md)
- [BarcodeDto3](docs/Model/BarcodeDto3.md)
- [BarcodeDto4](docs/Model/BarcodeDto4.md)
- [BarcodeDto5](docs/Model/BarcodeDto5.md)
- [BarcodeDto6](docs/Model/BarcodeDto6.md)
- [BarcodeDto7](docs/Model/BarcodeDto7.md)
- [BarcodeDto8](docs/Model/BarcodeDto8.md)
- [BarcodeItem](docs/Model/BarcodeItem.md)
- [ButtonImageDto](docs/Model/ButtonImageDto.md)
- [ButtonImageDto2](docs/Model/ButtonImageDto2.md)
- [ButtonImageDto3](docs/Model/ButtonImageDto3.md)
- [ComboCategoryDto](docs/Model/ComboCategoryDto.md)
- [ComboCategoryDto2](docs/Model/ComboCategoryDto2.md)
- [ComboCategoryDto3](docs/Model/ComboCategoryDto3.md)
- [ComboDto](docs/Model/ComboDto.md)
- [ComboDto2](docs/Model/ComboDto2.md)
- [ComboDto2ImageInner](docs/Model/ComboDto2ImageInner.md)
- [ComboDto3](docs/Model/ComboDto3.md)
- [ComboDto3ImageInner](docs/Model/ComboDto3ImageInner.md)
- [ComboDtoImageInner](docs/Model/ComboDtoImageInner.md)
- [ComboGroupDto](docs/Model/ComboGroupDto.md)
- [ComboGroupDto2](docs/Model/ComboGroupDto2.md)
- [ComboGroupDto3](docs/Model/ComboGroupDto3.md)
- [ComboGroupDto4](docs/Model/ComboGroupDto4.md)
- [ComboGroupItemDto](docs/Model/ComboGroupItemDto.md)
- [ComboGroupItemDto2](docs/Model/ComboGroupItemDto2.md)
- [ComboGroupItemDto3](docs/Model/ComboGroupItemDto3.md)
- [ComboGroupItemDto4](docs/Model/ComboGroupItemDto4.md)
- [ComboGroupItemSizeDto](docs/Model/ComboGroupItemSizeDto.md)
- [ComboGroupItemSizeDto2](docs/Model/ComboGroupItemSizeDto2.md)
- [ComboGroupItemSizeDto3](docs/Model/ComboGroupItemSizeDto3.md)
- [ComboGroupItemSizeDto4](docs/Model/ComboGroupItemSizeDto4.md)
- [ComboSizeDto](docs/Model/ComboSizeDto.md)
- [ComboSizeDto2](docs/Model/ComboSizeDto2.md)
- [ComboSizeDto3](docs/Model/ComboSizeDto3.md)
- [CostPriceItem](docs/Model/CostPriceItem.md)
- [Counteragent](docs/Model/Counteragent.md)
- [CustomerTagGroup](docs/Model/CustomerTagGroup.md)
- [CustomerTagGroup2](docs/Model/CustomerTagGroup2.md)
- [CustomerTagGroup3](docs/Model/CustomerTagGroup3.md)
- [CustomerTagItem](docs/Model/CustomerTagItem.md)
- [CustomerTagItem2](docs/Model/CustomerTagItem2.md)
- [CustomerTagItem3](docs/Model/CustomerTagItem3.md)
- [DisassembleDocumentCreateItem](docs/Model/DisassembleDocumentCreateItem.md)
- [DisassembleDocumentCreateRequest](docs/Model/DisassembleDocumentCreateRequest.md)
- [DisassembleDocumentGetItem](docs/Model/DisassembleDocumentGetItem.md)
- [DisassembleDocumentGetResponse](docs/Model/DisassembleDocumentGetResponse.md)
- [DisassembleDocumentListItem](docs/Model/DisassembleDocumentListItem.md)
- [DisassembleDocumentSaveResponse](docs/Model/DisassembleDocumentSaveResponse.md)
- [DisassembleDocumentUpdateRequest](docs/Model/DisassembleDocumentUpdateRequest.md)
- [DocumentTransactionItem](docs/Model/DocumentTransactionItem.md)
- [DocumentTransactionsListRequest](docs/Model/DocumentTransactionsListRequest.md)
- [ErrorResponse](docs/Model/ErrorResponse.md)
- [ExternalMenuCategory](docs/Model/ExternalMenuCategory.md)
- [ExternalMenuCategory2](docs/Model/ExternalMenuCategory2.md)
- [ExternalMenuCategory3](docs/Model/ExternalMenuCategory3.md)
- [ExternalMenuCategory3ItemsInner](docs/Model/ExternalMenuCategory3ItemsInner.md)
- [ExternalMenuComboItem](docs/Model/ExternalMenuComboItem.md)
- [ExternalMenuComboItemSize](docs/Model/ExternalMenuComboItemSize.md)
- [ExternalMenuItem](docs/Model/ExternalMenuItem.md)
- [ExternalMenuItem2](docs/Model/ExternalMenuItem2.md)
- [ExternalMenuItem3](docs/Model/ExternalMenuItem3.md)
- [ExternalMenuItemSize](docs/Model/ExternalMenuItemSize.md)
- [ExternalMenuItemSize2](docs/Model/ExternalMenuItemSize2.md)
- [ExternalMenuItemSize3](docs/Model/ExternalMenuItemSize3.md)
- [ExternalMenuItemSize4](docs/Model/ExternalMenuItemSize4.md)
- [ExternalMenuModifierGroup](docs/Model/ExternalMenuModifierGroup.md)
- [ExternalMenuModifierGroup2](docs/Model/ExternalMenuModifierGroup2.md)
- [ExternalMenuModifierGroup3](docs/Model/ExternalMenuModifierGroup3.md)
- [ExternalMenuModifierGroup4](docs/Model/ExternalMenuModifierGroup4.md)
- [ExternalMenuModifierItem](docs/Model/ExternalMenuModifierItem.md)
- [ExternalMenuModifierItem2](docs/Model/ExternalMenuModifierItem2.md)
- [ExternalMenuModifierItem3](docs/Model/ExternalMenuModifierItem3.md)
- [ExternalMenuModifierItem4](docs/Model/ExternalMenuModifierItem4.md)
- [ExternalMenuPriceByDepartmentsDto](docs/Model/ExternalMenuPriceByDepartmentsDto.md)
- [ExternalMenuPriceByDepartmentsDto2](docs/Model/ExternalMenuPriceByDepartmentsDto2.md)
- [ExternalMenuPriceByDepartmentsDto3](docs/Model/ExternalMenuPriceByDepartmentsDto3.md)
- [ExternalMenuPriceByDepartmentsDto4](docs/Model/ExternalMenuPriceByDepartmentsDto4.md)
- [ExternalMenuPriceByDepartmentsDto5](docs/Model/ExternalMenuPriceByDepartmentsDto5.md)
- [ExternalMenuPriceByDepartmentsDto6](docs/Model/ExternalMenuPriceByDepartmentsDto6.md)
- [ExternalMenuPriceByDepartmentsDto7](docs/Model/ExternalMenuPriceByDepartmentsDto7.md)
- [ExternalMenuPriceByDepartmentsDto8](docs/Model/ExternalMenuPriceByDepartmentsDto8.md)
- [ExternalMenuV2](docs/Model/ExternalMenuV2.md)
- [ExternalMenuV3](docs/Model/ExternalMenuV3.md)
- [ExternalMenuV4](docs/Model/ExternalMenuV4.md)
- [GetCostPricesRequest](docs/Model/GetCostPricesRequest.md)
- [GetCostPricesResponse](docs/Model/GetCostPricesResponse.md)
- [GetCounteragentsRequest](docs/Model/GetCounteragentsRequest.md)
- [GetCounteragentsResponse](docs/Model/GetCounteragentsResponse.md)
- [IikoNetCommonEnumsCounterMetric](docs/Model/IikoNetCommonEnumsCounterMetric.md)
- [IikoNetCommonEnumsCounterPeriod](docs/Model/IikoNetCommonEnumsCounterPeriod.md)
- [IikoNetCommonEnumsTemplateType](docs/Model/IikoNetCommonEnumsTemplateType.md)
- [IikoNetServiceContractsApiIikoTransportCommonGetByOrganizationIdRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCommonGetByOrganizationIdRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerAddCustomerToProgramRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerAddCustomerToProgramRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerAddCustomerToProgramResponse](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerAddCustomerToProgramResponse.md)
- [IikoNetServiceContractsApiIikoTransportCustomerAddMagnetCardRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerAddMagnetCardRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerCancelHoldMoneyRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerCancelHoldMoneyRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerChangeCategoryForCustomerRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerChangeCategoryForCustomerRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerChangeUserBalanceRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerChangeUserBalanceRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerCreateOrUpdateCustomerRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerCreateOrUpdateCustomerRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerCreateOrUpdateCustomerResponse](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerCreateOrUpdateCustomerResponse.md)
- [IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersResponse](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersResponse.md)
- [IikoNetServiceContractsApiIikoTransportCustomerDeleteMagnetCardRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerDeleteMagnetCardRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesResponse](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesResponse.md)
- [IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoByCardNumberRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoByCardNumberRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoByCardTrackRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoByCardTrackRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoByEmailRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoByEmailRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoByIdRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoByIdRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoByPhoneRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoByPhoneRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoResponse](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoResponse.md)
- [IikoNetServiceContractsApiIikoTransportCustomerGuestBalanceInfo](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerGuestBalanceInfo.md)
- [IikoNetServiceContractsApiIikoTransportCustomerGuestCardInfo](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerGuestCardInfo.md)
- [IikoNetServiceContractsApiIikoTransportCustomerGuestCategoryShortInfo](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerGuestCategoryShortInfo.md)
- [IikoNetServiceContractsApiIikoTransportCustomerHoldMoneyRequest](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerHoldMoneyRequest.md)
- [IikoNetServiceContractsApiIikoTransportCustomerHoldMoneyResponse](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerHoldMoneyResponse.md)
- [IikoNetServiceContractsApiIikoTransportCustomerIikoNetUserSex](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerIikoNetUserSex.md)
- [IikoNetServiceContractsApiIikoTransportCustomerRestoreCustomersResponse](docs/Model/IikoNetServiceContractsApiIikoTransportCustomerRestoreCustomersResponse.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultAvailableCombo](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultAvailableCombo.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultAvailablePayment](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultAvailablePayment.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateCheckinRequest](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateCheckinRequest.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateCheckinResponse](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateCheckinResponse.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateComboPriceRequest](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateComboPriceRequest.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateComboPriceResponse](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateComboPriceResponse.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultComboCategory](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultComboCategory.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultComboGroup](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultComboGroup.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultComboGroupMapping](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultComboGroupMapping.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultComboPriceModificationType](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultComboPriceModificationType.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultComboProduct](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultComboProduct.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultComboSpecification](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultComboSpecification.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultCouponInfo](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultCouponInfo.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultCouponInfoRequest](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultCouponInfoRequest.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultCouponInfoResponse](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultCouponInfoResponse.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultDiscountOperation](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultDiscountOperation.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultDynamicDiscount](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultDynamicDiscount.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultFreeProduct](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultFreeProduct.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultFreeProductSize](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultFreeProductSize.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultFreeProductsGroup](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultFreeProductsGroup.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCombosInfoRequest](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCombosInfoRequest.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCombosInfoResponse](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCombosInfoResponse.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCountersRequest](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCountersRequest.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCountersResponse](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCountersResponse.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultGetManualConditionsResponse](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultGetManualConditionsResponse.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultGuestCounter](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultGuestCounter.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultLoyaltyProgramResult](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultLoyaltyProgramResult.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultManualConditionInfo](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultManualConditionInfo.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultNotActivatedCoupon](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultNotActivatedCoupon.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultNotActivatedCouponRequest](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultNotActivatedCouponRequest.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultNotActivatedCouponResponse](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultNotActivatedCouponResponse.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultSeriesWithNotActivatedCoupons](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultSeriesWithNotActivatedCoupons.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultSeriesWithNotActivatedCouponsResponse](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultSeriesWithNotActivatedCouponsResponse.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultUpsale](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultUpsale.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultUpsaleProduct](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultUpsaleProduct.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultWalletInfo](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultWalletInfo.md)
- [IikoNetServiceContractsApiIikoTransportLoyaltyResultWarningInfo](docs/Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultWarningInfo.md)
- [IikoNetServiceContractsApiIikoTransportNotificationCheckSmsStatusRequest](docs/Model/IikoNetServiceContractsApiIikoTransportNotificationCheckSmsStatusRequest.md)
- [IikoNetServiceContractsApiIikoTransportNotificationCheckSmsStatusResponse](docs/Model/IikoNetServiceContractsApiIikoTransportNotificationCheckSmsStatusResponse.md)
- [IikoNetServiceContractsApiIikoTransportNotificationSendEmailRequest](docs/Model/IikoNetServiceContractsApiIikoTransportNotificationSendEmailRequest.md)
- [IikoNetServiceContractsApiIikoTransportNotificationSendSmsRequest](docs/Model/IikoNetServiceContractsApiIikoTransportNotificationSendSmsRequest.md)
- [IikoNetServiceContractsApiIikoTransportNotificationSendSmsResponse](docs/Model/IikoNetServiceContractsApiIikoTransportNotificationSendSmsResponse.md)
- [IikoNetServiceContractsApiIikoTransportNotificationSmsSendingPossibilityResponse](docs/Model/IikoNetServiceContractsApiIikoTransportNotificationSmsSendingPossibilityResponse.md)
- [IikoNetServiceContractsApiIikoTransportNotificationSmsSendingStatusInfo](docs/Model/IikoNetServiceContractsApiIikoTransportNotificationSmsSendingStatusInfo.md)
- [IikoNetServiceContractsApiIikoTransportOrganizationGetProgramsRequest](docs/Model/IikoNetServiceContractsApiIikoTransportOrganizationGetProgramsRequest.md)
- [IikoNetServiceContractsApiIikoTransportOrganizationGetProgramsResponse](docs/Model/IikoNetServiceContractsApiIikoTransportOrganizationGetProgramsResponse.md)
- [IikoNetServiceContractsApiIikoTransportOrganizationLoyaltyProgram](docs/Model/IikoNetServiceContractsApiIikoTransportOrganizationLoyaltyProgram.md)
- [IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignActionConditionBindingInfo](docs/Model/IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignActionConditionBindingInfo.md)
- [IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignInfo](docs/Model/IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignInfo.md)
- [IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignSettingsInfo](docs/Model/IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignSettingsInfo.md)
- [IikoNetServiceContractsApiIikoTransportProgramType](docs/Model/IikoNetServiceContractsApiIikoTransportProgramType.md)
- [IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByPeriodRequest](docs/Model/IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByPeriodRequest.md)
- [IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByPeriodResponse](docs/Model/IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByPeriodResponse.md)
- [IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByRevisionRequest](docs/Model/IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByRevisionRequest.md)
- [IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByRevisionResponse](docs/Model/IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByRevisionResponse.md)
- [IikoNetServiceContractsApiIikoTransportReportTransactionType](docs/Model/IikoNetServiceContractsApiIikoTransportReportTransactionType.md)
- [IikoNetServiceContractsApiIikoTransportReportTransportTransactionsCertificateReportItem](docs/Model/IikoNetServiceContractsApiIikoTransportReportTransportTransactionsCertificateReportItem.md)
- [IikoNetServiceContractsApiIikoTransportReportTransportTransactionsCouponReportItem](docs/Model/IikoNetServiceContractsApiIikoTransportReportTransportTransactionsCouponReportItem.md)
- [IikoNetServiceContractsApiIikoTransportReportTransportTransactionsReportItem](docs/Model/IikoNetServiceContractsApiIikoTransportReportTransportTransactionsReportItem.md)
- [IikoTransportPublicApiContractsAddressCitiesRequest](docs/Model/IikoTransportPublicApiContractsAddressCitiesRequest.md)
- [IikoTransportPublicApiContractsAddressCitiesResponse](docs/Model/IikoTransportPublicApiContractsAddressCitiesResponse.md)
- [IikoTransportPublicApiContractsAddressCity](docs/Model/IikoTransportPublicApiContractsAddressCity.md)
- [IikoTransportPublicApiContractsAddressHintsAddressHintsServiceType](docs/Model/IikoTransportPublicApiContractsAddressHintsAddressHintsServiceType.md)
- [IikoTransportPublicApiContractsAddressRegion](docs/Model/IikoTransportPublicApiContractsAddressRegion.md)
- [IikoTransportPublicApiContractsAddressRegionsRequest](docs/Model/IikoTransportPublicApiContractsAddressRegionsRequest.md)
- [IikoTransportPublicApiContractsAddressRegionsResponse](docs/Model/IikoTransportPublicApiContractsAddressRegionsResponse.md)
- [IikoTransportPublicApiContractsAddressStreet](docs/Model/IikoTransportPublicApiContractsAddressStreet.md)
- [IikoTransportPublicApiContractsAddressStreetById](docs/Model/IikoTransportPublicApiContractsAddressStreetById.md)
- [IikoTransportPublicApiContractsAddressStreetsByCityRequest](docs/Model/IikoTransportPublicApiContractsAddressStreetsByCityRequest.md)
- [IikoTransportPublicApiContractsAddressStreetsByIdRequest](docs/Model/IikoTransportPublicApiContractsAddressStreetsByIdRequest.md)
- [IikoTransportPublicApiContractsAddressStreetsByIdResponse](docs/Model/IikoTransportPublicApiContractsAddressStreetsByIdResponse.md)
- [IikoTransportPublicApiContractsAddressStreetsResponse](docs/Model/IikoTransportPublicApiContractsAddressStreetsResponse.md)
- [IikoTransportPublicApiContractsAuthGetAccessTokenRequest](docs/Model/IikoTransportPublicApiContractsAuthGetAccessTokenRequest.md)
- [IikoTransportPublicApiContractsAuthGetAccessTokenResponse](docs/Model/IikoTransportPublicApiContractsAuthGetAccessTokenResponse.md)
- [IikoTransportPublicApiContractsAuthGetAccessTokenV2Request](docs/Model/IikoTransportPublicApiContractsAuthGetAccessTokenV2Request.md)
- [IikoTransportPublicApiContractsCancelCausesCancelCause](docs/Model/IikoTransportPublicApiContractsCancelCausesCancelCause.md)
- [IikoTransportPublicApiContractsCancelCausesCancelCausesResponse](docs/Model/IikoTransportPublicApiContractsCancelCausesCancelCausesResponse.md)
- [IikoTransportPublicApiContractsCommandsErrorCommandStatus](docs/Model/IikoTransportPublicApiContractsCommandsErrorCommandStatus.md)
- [IikoTransportPublicApiContractsCommandsGetCommandStatusRequest](docs/Model/IikoTransportPublicApiContractsCommandsGetCommandStatusRequest.md)
- [IikoTransportPublicApiContractsCommandsGetCommandStatusResponse](docs/Model/IikoTransportPublicApiContractsCommandsGetCommandStatusResponse.md)
- [IikoTransportPublicApiContractsCommandsInProgressCommandStatus](docs/Model/IikoTransportPublicApiContractsCommandsInProgressCommandStatus.md)
- [IikoTransportPublicApiContractsCommonCorrelationIdResponse](docs/Model/IikoTransportPublicApiContractsCommonCorrelationIdResponse.md)
- [IikoTransportPublicApiContractsCommonExternalData](docs/Model/IikoTransportPublicApiContractsCommonExternalData.md)
- [IikoTransportPublicApiContractsCommonPriceCategory](docs/Model/IikoTransportPublicApiContractsCommonPriceCategory.md)
- [IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsAddressCityIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull](docs/Model/IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsAddressCityIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull.md)
- [IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsAddressRegionIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull](docs/Model/IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsAddressRegionIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull.md)
- [IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsDiscountsDiscountCardTypeInfoIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull](docs/Model/IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsDiscountsDiscountCardTypeInfoIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull.md)
- [IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsEmployeesActiveCourierLocationIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull](docs/Model/IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsEmployeesActiveCourierLocationIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull.md)
- [IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsEmployeesCourierLocationsIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull](docs/Model/IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsEmployeesCourierLocationsIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull.md)
- [IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsEmployeesEmployeeIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull](docs/Model/IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsEmployeesEmployeeIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull.md)
- [IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsEmployeesEmployeeWithCheckedRoleIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull](docs/Model/IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsEmployeesEmployeeWithCheckedRoleIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull.md)
- [IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsOrderTypesOrderTypeIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull](docs/Model/IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsOrderTypesOrderTypeIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull.md)
- [IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsStopListsTerminalGroupStopListIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull](docs/Model/IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsStopListsTerminalGroupStopListIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull.md)
- [IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsTerminalsTerminalGroupIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull](docs/Model/IikoTransportPublicApiContractsCommonRmsItemsResponseWrapper1IikoTransportPublicApiContractsTerminalsTerminalGroupIikoTransportPublicApiContractsVersion9752CultureNeutralPublicKeyTokenNull.md)
- [IikoTransportPublicApiContractsCommonSortDirection](docs/Model/IikoTransportPublicApiContractsCommonSortDirection.md)
- [IikoTransportPublicApiContractsDeliveriesCommonCardPaymentAdditionalData](docs/Model/IikoTransportPublicApiContractsDeliveriesCommonCardPaymentAdditionalData.md)
- [IikoTransportPublicApiContractsDeliveriesCommonChequeAdditionalInfo](docs/Model/IikoTransportPublicApiContractsDeliveriesCommonChequeAdditionalInfo.md)
- [IikoTransportPublicApiContractsDeliveriesCommonCoordinates](docs/Model/IikoTransportPublicApiContractsDeliveriesCommonCoordinates.md)
- [IikoTransportPublicApiContractsDeliveriesCommonDeliveryStatus](docs/Model/IikoTransportPublicApiContractsDeliveriesCommonDeliveryStatus.md)
- [IikoTransportPublicApiContractsDeliveriesCommonDeliveryStatusForUpdate](docs/Model/IikoTransportPublicApiContractsDeliveriesCommonDeliveryStatusForUpdate.md)
- [IikoTransportPublicApiContractsDeliveriesCommonExternalPaymentAdditionalData](docs/Model/IikoTransportPublicApiContractsDeliveriesCommonExternalPaymentAdditionalData.md)
- [IikoTransportPublicApiContractsDeliveriesCommonGender](docs/Model/IikoTransportPublicApiContractsDeliveriesCommonGender.md)
- [IikoTransportPublicApiContractsDeliveriesCommonIikoCardSearchScope](docs/Model/IikoTransportPublicApiContractsDeliveriesCommonIikoCardSearchScope.md)
- [IikoTransportPublicApiContractsDeliveriesCommonLoyaltyCardPaymentAdditionalData](docs/Model/IikoTransportPublicApiContractsDeliveriesCommonLoyaltyCardPaymentAdditionalData.md)
- [IikoTransportPublicApiContractsDeliveriesCommonOrderServiceType](docs/Model/IikoTransportPublicApiContractsDeliveriesCommonOrderServiceType.md)
- [IikoTransportPublicApiContractsDeliveriesCommonPaymentAdditionalData](docs/Model/IikoTransportPublicApiContractsDeliveriesCommonPaymentAdditionalData.md)
- [IikoTransportPublicApiContractsDeliveriesCommonPaymentTypeKind](docs/Model/IikoTransportPublicApiContractsDeliveriesCommonPaymentTypeKind.md)
- [IikoTransportPublicApiContractsDeliveriesDraftsCommitDraftRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesDraftsCommitDraftRequest.md)
- [IikoTransportPublicApiContractsDeliveriesDraftsCreateDraftRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesDraftsCreateDraftRequest.md)
- [IikoTransportPublicApiContractsDeliveriesDraftsCreateOrSaveDraftResponse](docs/Model/IikoTransportPublicApiContractsDeliveriesDraftsCreateOrSaveDraftResponse.md)
- [IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest.md)
- [IikoTransportPublicApiContractsDeliveriesDraftsDeliveryOrderDraft](docs/Model/IikoTransportPublicApiContractsDeliveriesDraftsDeliveryOrderDraft.md)
- [IikoTransportPublicApiContractsDeliveriesDraftsFilterDraftsRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesDraftsFilterDraftsRequest.md)
- [IikoTransportPublicApiContractsDeliveriesDraftsFilterDraftsResponse](docs/Model/IikoTransportPublicApiContractsDeliveriesDraftsFilterDraftsResponse.md)
- [IikoTransportPublicApiContractsDeliveriesDraftsGetDraftResponse](docs/Model/IikoTransportPublicApiContractsDeliveriesDraftsGetDraftResponse.md)
- [IikoTransportPublicApiContractsDeliveriesDraftsLockOrUnlockDraftRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesDraftsLockOrUnlockDraftRequest.md)
- [IikoTransportPublicApiContractsDeliveriesDraftsOrderDraft](docs/Model/IikoTransportPublicApiContractsDeliveriesDraftsOrderDraft.md)
- [IikoTransportPublicApiContractsDeliveriesDraftsOrderDraftSortProperty](docs/Model/IikoTransportPublicApiContractsDeliveriesDraftsOrderDraftSortProperty.md)
- [IikoTransportPublicApiContractsDeliveriesDraftsSaveDraftRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesDraftsSaveDraftRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestAddOrderItemsRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestAddOrderItemsRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCancelOrderRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCancelOrderRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCancelTableOrderRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCancelTableOrderRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestChangeDriverInfoRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestChangeDriverInfoRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCloseDeliveryOrderRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCloseDeliveryOrderRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCloseTableOrderRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCloseTableOrderRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderAddress](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderAddress.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderAddressCity](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderAddressCity.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderAddressLegacy](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderAddressLegacy.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderAnonymousCustomer](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderAnonymousCustomer.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCardPayment](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCardPayment.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCardTipsPayment](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCardTipsPayment.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCashPayment](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCashPayment.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCashTipsPayment](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCashTipsPayment.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCombo](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCombo.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderComboItemInformation](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderComboItemInformation.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCompoundOrderItem](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCompoundOrderItem.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCompoundOrderItemComponent](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCompoundOrderItemComponent.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCustomer](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCustomer.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDeliveryOrder](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDeliveryOrder.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDeliveryPoint](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDeliveryPoint.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDiscount](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDiscount.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDiscountCard](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDiscountCard.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDiscountsInfo](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDiscountsInfo.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDynamicDiscount](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDynamicDiscount.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderExternalData](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderExternalData.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderGuests](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderGuests.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderIikoCardDiscount](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderIikoCardDiscount.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderIikoCardDiscountItem](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderIikoCardDiscountItem.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderLoyaltyInfo](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderLoyaltyInfo.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderModifier](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderModifier.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrder](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrder.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderItem](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderItem.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderServiceType](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderServiceType.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderPayment](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderPayment.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderProductOrderItem](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderProductOrderItem.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderRegularCustomer](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderRegularCustomer.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderRmsDiscount](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderRmsDiscount.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderStreet](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderStreet.md)
- [IikoTransportPublicApiContractsDeliveriesRequestCreateOrderTipsPayment](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderTipsPayment.md)
- [IikoTransportPublicApiContractsDeliveriesRequestOrderSortProperty](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestOrderSortProperty.md)
- [IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndFilterRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndFilterRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndPhoneRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndPhoneRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndStatusRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndStatusRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestOrdersByIdRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestOrdersByIdRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestOrdersByRevisionRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestOrdersByRevisionRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestOrdersHistoryByDeliveryDateAndPhoneRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestOrdersHistoryByDeliveryDateAndPhoneRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestUpdateDeliveryStatusRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateDeliveryStatusRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeCompleteBeforeRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeCompleteBeforeRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryCommentRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryCommentRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryOperatorRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryOperatorRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryPointRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryPointRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeExternalDataRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeExternalDataRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangePaymentsRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangePaymentsRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeServiceTypeDeliveryByClient](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeServiceTypeDeliveryByClient.md)
- [IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeServiceTypeDeliveryByCourier](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeServiceTypeDeliveryByCourier.md)
- [IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeServiceTypeRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeServiceTypeRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderOrderPaymentItem](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderOrderPaymentItem.md)
- [IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderPaymentsRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderPaymentsRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderProblemRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderProblemRequest.md)
- [IikoTransportPublicApiContractsDeliveriesRequestUpdateTrackingLinkRequest](docs/Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateTrackingLinkRequest.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderAddress](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderAddress.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderAnonymousCustomer](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderAnonymousCustomer.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderCancelInfo](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderCancelInfo.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderComboItemInformation](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderComboItemInformation.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderCompoundOrderItem](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderCompoundOrderItem.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderCompoundOrderItemComponent](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderCompoundOrderItemComponent.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderConception](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderConception.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderCourierInfo](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderCourierInfo.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderCreationStatus](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderCreationStatus.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderCustomer](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderCustomer.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderDeletionMethod](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderDeletionMethod.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderDeliveryPoint](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderDeliveryPoint.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderDiscountItem](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderDiscountItem.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderEmployee](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderEmployee.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderGuestsInfo](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderGuestsInfo.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderIdentifierCode](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderIdentifierCode.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderItemDeletedInfo](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderItemDeletedInfo.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderLoyaltyInfo](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderLoyaltyInfo.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderOrder](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderOrder.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderOrderCombo](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderOrderCombo.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderOrderInfo](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderOrderInfo.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItem](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItem.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemIdentifierCode](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemIdentifierCode.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemModifier](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemModifier.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemStatus](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemStatus.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderOrderStatus](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderOrderStatus.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderOrderType](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderOrderType.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderPaymentItem](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderPaymentItem.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderPaymentType](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderPaymentType.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderPositionWithSum](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderPositionWithSum.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderProblem](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderProblem.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderProductOrderItem](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderProductOrderItem.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderRegularCustomer](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderRegularCustomer.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderResponse](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderResponse.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderServiceOrderItem](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderServiceOrderItem.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderStreet](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderStreet.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrderTipsPaymentItem](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrderTipsPaymentItem.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrdersByOrganization](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrdersByOrganization.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrdersResponse](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrdersResponse.md)
- [IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse](docs/Model/IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsActionOnValidationRejection](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsActionOnValidationRejection.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsAllowedItemWithDuration](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsAllowedItemWithDuration.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsDeliveryRestrictionRejectCode](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsDeliveryRestrictionRejectCode.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsGetAllowedRestrictionsRequest](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsGetAllowedRestrictionsRequest.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsGetAllowedRestrictionsResponse](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsGetAllowedRestrictionsResponse.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRejectItem](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRejectItem.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRejectItemData](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRejectItemData.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRestrictionsAddress](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRestrictionsAddress.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRestrictionsOrderItem](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRestrictionsOrderItem.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRestrictionsOrderItemModifier](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRestrictionsOrderItemModifier.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryGeocodeServiceType](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryGeocodeServiceType.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryRestrictionItem](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryRestrictionItem.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryRestrictions](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryRestrictions.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryZone](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryZone.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryZoneAddressBinding](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsDeliveryZoneAddressBinding.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsGetDeliveryRestrictionsResponse](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsGetDeliveryRestrictionsResponse.md)
- [IikoTransportPublicApiContractsDeliveryRestrictionsHousesRange](docs/Model/IikoTransportPublicApiContractsDeliveryRestrictionsHousesRange.md)
- [IikoTransportPublicApiContractsDiscountsDiscountCardMode](docs/Model/IikoTransportPublicApiContractsDiscountsDiscountCardMode.md)
- [IikoTransportPublicApiContractsDiscountsDiscountCardTypeInfo](docs/Model/IikoTransportPublicApiContractsDiscountsDiscountCardTypeInfo.md)
- [IikoTransportPublicApiContractsDiscountsDiscountsResponse](docs/Model/IikoTransportPublicApiContractsDiscountsDiscountsResponse.md)
- [IikoTransportPublicApiContractsDiscountsProductCategoryDiscount](docs/Model/IikoTransportPublicApiContractsDiscountsProductCategoryDiscount.md)
- [IikoTransportPublicApiContractsEmployeesActiveCourierLocation](docs/Model/IikoTransportPublicApiContractsEmployeesActiveCourierLocation.md)
- [IikoTransportPublicApiContractsEmployeesActiveCourierLocationsByTerminalGroupRequest](docs/Model/IikoTransportPublicApiContractsEmployeesActiveCourierLocationsByTerminalGroupRequest.md)
- [IikoTransportPublicApiContractsEmployeesActiveCourierLocationsResponse](docs/Model/IikoTransportPublicApiContractsEmployeesActiveCourierLocationsResponse.md)
- [IikoTransportPublicApiContractsEmployeesChangePersonalSessionResponse](docs/Model/IikoTransportPublicApiContractsEmployeesChangePersonalSessionResponse.md)
- [IikoTransportPublicApiContractsEmployeesClosePersonalSessionRequest](docs/Model/IikoTransportPublicApiContractsEmployeesClosePersonalSessionRequest.md)
- [IikoTransportPublicApiContractsEmployeesCoordinateInfo](docs/Model/IikoTransportPublicApiContractsEmployeesCoordinateInfo.md)
- [IikoTransportPublicApiContractsEmployeesCourierLocations](docs/Model/IikoTransportPublicApiContractsEmployeesCourierLocations.md)
- [IikoTransportPublicApiContractsEmployeesCourierLocationsByTimeOffsetRequest](docs/Model/IikoTransportPublicApiContractsEmployeesCourierLocationsByTimeOffsetRequest.md)
- [IikoTransportPublicApiContractsEmployeesCourierLocationsByTimeOffsetResponse](docs/Model/IikoTransportPublicApiContractsEmployeesCourierLocationsByTimeOffsetResponse.md)
- [IikoTransportPublicApiContractsEmployeesCouriersAndCheckRoleRequest](docs/Model/IikoTransportPublicApiContractsEmployeesCouriersAndCheckRoleRequest.md)
- [IikoTransportPublicApiContractsEmployeesEmployee](docs/Model/IikoTransportPublicApiContractsEmployeesEmployee.md)
- [IikoTransportPublicApiContractsEmployeesEmployeeInfo](docs/Model/IikoTransportPublicApiContractsEmployeesEmployeeInfo.md)
- [IikoTransportPublicApiContractsEmployeesEmployeeInfoRequest](docs/Model/IikoTransportPublicApiContractsEmployeesEmployeeInfoRequest.md)
- [IikoTransportPublicApiContractsEmployeesEmployeeInfoResponse](docs/Model/IikoTransportPublicApiContractsEmployeesEmployeeInfoResponse.md)
- [IikoTransportPublicApiContractsEmployeesEmployeeWithCheckedRole](docs/Model/IikoTransportPublicApiContractsEmployeesEmployeeWithCheckedRole.md)
- [IikoTransportPublicApiContractsEmployeesEmployeesResponse](docs/Model/IikoTransportPublicApiContractsEmployeesEmployeesResponse.md)
- [IikoTransportPublicApiContractsEmployeesEmployeesWithRoleSignResponse](docs/Model/IikoTransportPublicApiContractsEmployeesEmployeesWithRoleSignResponse.md)
- [IikoTransportPublicApiContractsEmployeesGetPersonalSessionInfoResponse](docs/Model/IikoTransportPublicApiContractsEmployeesGetPersonalSessionInfoResponse.md)
- [IikoTransportPublicApiContractsEmployeesGetTerminalGroupsOfEmployeeRequest](docs/Model/IikoTransportPublicApiContractsEmployeesGetTerminalGroupsOfEmployeeRequest.md)
- [IikoTransportPublicApiContractsEmployeesGetTerminalGroupsOfEmployeeResponse](docs/Model/IikoTransportPublicApiContractsEmployeesGetTerminalGroupsOfEmployeeResponse.md)
- [IikoTransportPublicApiContractsEmployeesOpenPersonalSessionRequest](docs/Model/IikoTransportPublicApiContractsEmployeesOpenPersonalSessionRequest.md)
- [IikoTransportPublicApiContractsEmployeesPersonalShift](docs/Model/IikoTransportPublicApiContractsEmployeesPersonalShift.md)
- [IikoTransportPublicApiContractsEmployeesRoleCheckResult](docs/Model/IikoTransportPublicApiContractsEmployeesRoleCheckResult.md)
- [IikoTransportPublicApiContractsErrorsErrorCode](docs/Model/IikoTransportPublicApiContractsErrorsErrorCode.md)
- [IikoTransportPublicApiContractsErrorsErrorInfo](docs/Model/IikoTransportPublicApiContractsErrorsErrorInfo.md)
- [IikoTransportPublicApiContractsErrorsErrorResponse](docs/Model/IikoTransportPublicApiContractsErrorsErrorResponse.md)
- [IikoTransportPublicApiContractsIntegrationWebHooksFiltersDeliveryOrderWebHooksFilter](docs/Model/IikoTransportPublicApiContractsIntegrationWebHooksFiltersDeliveryOrderWebHooksFilter.md)
- [IikoTransportPublicApiContractsIntegrationWebHooksFiltersReserveWebHookFilter](docs/Model/IikoTransportPublicApiContractsIntegrationWebHooksFiltersReserveWebHookFilter.md)
- [IikoTransportPublicApiContractsIntegrationWebHooksFiltersTableOrderWebHookFilter](docs/Model/IikoTransportPublicApiContractsIntegrationWebHooksFiltersTableOrderWebHookFilter.md)
- [IikoTransportPublicApiContractsIntegrationWebHooksFiltersWebHookShortFilter](docs/Model/IikoTransportPublicApiContractsIntegrationWebHooksFiltersWebHookShortFilter.md)
- [IikoTransportPublicApiContractsIntegrationWebHooksFiltersWebHooksFilter](docs/Model/IikoTransportPublicApiContractsIntegrationWebHooksFiltersWebHooksFilter.md)
- [IikoTransportPublicApiContractsMarketingSourcesMarketingSource](docs/Model/IikoTransportPublicApiContractsMarketingSourcesMarketingSource.md)
- [IikoTransportPublicApiContractsMarketingSourcesMarketingSourcesResponse](docs/Model/IikoTransportPublicApiContractsMarketingSourcesMarketingSourcesResponse.md)
- [IikoTransportPublicApiContractsMetricsCallCenterAction](docs/Model/IikoTransportPublicApiContractsMetricsCallCenterAction.md)
- [IikoTransportPublicApiContractsMetricsCallCenterTelemetry](docs/Model/IikoTransportPublicApiContractsMetricsCallCenterTelemetry.md)
- [IikoTransportPublicApiContractsNomenclatureChildModifierInfo](docs/Model/IikoTransportPublicApiContractsNomenclatureChildModifierInfo.md)
- [IikoTransportPublicApiContractsNomenclatureExternalMenu](docs/Model/IikoTransportPublicApiContractsNomenclatureExternalMenu.md)
- [IikoTransportPublicApiContractsNomenclatureGroupModifierInfo](docs/Model/IikoTransportPublicApiContractsNomenclatureGroupModifierInfo.md)
- [IikoTransportPublicApiContractsNomenclatureMenuRequest](docs/Model/IikoTransportPublicApiContractsNomenclatureMenuRequest.md)
- [IikoTransportPublicApiContractsNomenclatureMenusDataResponse](docs/Model/IikoTransportPublicApiContractsNomenclatureMenusDataResponse.md)
- [IikoTransportPublicApiContractsNomenclatureNomenclatureRequest](docs/Model/IikoTransportPublicApiContractsNomenclatureNomenclatureRequest.md)
- [IikoTransportPublicApiContractsNomenclatureNomenclatureResponse](docs/Model/IikoTransportPublicApiContractsNomenclatureNomenclatureResponse.md)
- [IikoTransportPublicApiContractsNomenclatureOrderItemType](docs/Model/IikoTransportPublicApiContractsNomenclatureOrderItemType.md)
- [IikoTransportPublicApiContractsNomenclaturePrice](docs/Model/IikoTransportPublicApiContractsNomenclaturePrice.md)
- [IikoTransportPublicApiContractsNomenclatureProductCategoryInfo](docs/Model/IikoTransportPublicApiContractsNomenclatureProductCategoryInfo.md)
- [IikoTransportPublicApiContractsNomenclatureProductInfo](docs/Model/IikoTransportPublicApiContractsNomenclatureProductInfo.md)
- [IikoTransportPublicApiContractsNomenclatureProductsGroupInfo](docs/Model/IikoTransportPublicApiContractsNomenclatureProductsGroupInfo.md)
- [IikoTransportPublicApiContractsNomenclatureSize](docs/Model/IikoTransportPublicApiContractsNomenclatureSize.md)
- [IikoTransportPublicApiContractsNomenclatureSizePrice](docs/Model/IikoTransportPublicApiContractsNomenclatureSizePrice.md)
- [IikoTransportPublicApiContractsNotificationsDeliveryAttentionNotificationRequest](docs/Model/IikoTransportPublicApiContractsNotificationsDeliveryAttentionNotificationRequest.md)
- [IikoTransportPublicApiContractsNotificationsExternalCourierArrivedNotificationRequest](docs/Model/IikoTransportPublicApiContractsNotificationsExternalCourierArrivedNotificationRequest.md)
- [IikoTransportPublicApiContractsNotificationsOrderAttentionNotificationRequest](docs/Model/IikoTransportPublicApiContractsNotificationsOrderAttentionNotificationRequest.md)
- [IikoTransportPublicApiContractsNotificationsSendNotificationRequest](docs/Model/IikoTransportPublicApiContractsNotificationsSendNotificationRequest.md)
- [IikoTransportPublicApiContractsOrderTypesOrderServiceType](docs/Model/IikoTransportPublicApiContractsOrderTypesOrderServiceType.md)
- [IikoTransportPublicApiContractsOrderTypesOrderType](docs/Model/IikoTransportPublicApiContractsOrderTypesOrderType.md)
- [IikoTransportPublicApiContractsOrderTypesOrderTypesResponse](docs/Model/IikoTransportPublicApiContractsOrderTypesOrderTypesResponse.md)
- [IikoTransportPublicApiContractsOrdersCommonAddOrderPaymentsRequest](docs/Model/IikoTransportPublicApiContractsOrdersCommonAddOrderPaymentsRequest.md)
- [IikoTransportPublicApiContractsOrdersCommonCreateOrderSettings](docs/Model/IikoTransportPublicApiContractsOrdersCommonCreateOrderSettings.md)
- [IikoTransportPublicApiContractsOrganizationsAddressFormatType](docs/Model/IikoTransportPublicApiContractsOrganizationsAddressFormatType.md)
- [IikoTransportPublicApiContractsOrganizationsDeliveryOrderPaymentSettings](docs/Model/IikoTransportPublicApiContractsOrganizationsDeliveryOrderPaymentSettings.md)
- [IikoTransportPublicApiContractsOrganizationsDeliverySettingsServiceType](docs/Model/IikoTransportPublicApiContractsOrganizationsDeliverySettingsServiceType.md)
- [IikoTransportPublicApiContractsOrganizationsExtendedOrganizationInfo](docs/Model/IikoTransportPublicApiContractsOrganizationsExtendedOrganizationInfo.md)
- [IikoTransportPublicApiContractsOrganizationsGetOrganizationsRequest](docs/Model/IikoTransportPublicApiContractsOrganizationsGetOrganizationsRequest.md)
- [IikoTransportPublicApiContractsOrganizationsGetOrganizationsResponse](docs/Model/IikoTransportPublicApiContractsOrganizationsGetOrganizationsResponse.md)
- [IikoTransportPublicApiContractsOrganizationsGetSimpleOrganizationsResponse](docs/Model/IikoTransportPublicApiContractsOrganizationsGetSimpleOrganizationsResponse.md)
- [IikoTransportPublicApiContractsOrganizationsOrganizationInfo](docs/Model/IikoTransportPublicApiContractsOrganizationsOrganizationInfo.md)
- [IikoTransportPublicApiContractsOrganizationsOrganizationSettings](docs/Model/IikoTransportPublicApiContractsOrganizationsOrganizationSettings.md)
- [IikoTransportPublicApiContractsOrganizationsOrganizationSettingsParameters](docs/Model/IikoTransportPublicApiContractsOrganizationsOrganizationSettingsParameters.md)
- [IikoTransportPublicApiContractsOrganizationsOrganizationsSettingsRequest](docs/Model/IikoTransportPublicApiContractsOrganizationsOrganizationsSettingsRequest.md)
- [IikoTransportPublicApiContractsOrganizationsOrganizationsSettingsResponse](docs/Model/IikoTransportPublicApiContractsOrganizationsOrganizationsSettingsResponse.md)
- [IikoTransportPublicApiContractsOrganizationsSimpleOrganizationInfo](docs/Model/IikoTransportPublicApiContractsOrganizationsSimpleOrganizationInfo.md)
- [IikoTransportPublicApiContractsPaymentTypesPaymentProcessingType](docs/Model/IikoTransportPublicApiContractsPaymentTypesPaymentProcessingType.md)
- [IikoTransportPublicApiContractsPaymentTypesPaymentType](docs/Model/IikoTransportPublicApiContractsPaymentTypesPaymentType.md)
- [IikoTransportPublicApiContractsPaymentTypesPaymentTypeKind](docs/Model/IikoTransportPublicApiContractsPaymentTypesPaymentTypeKind.md)
- [IikoTransportPublicApiContractsPaymentTypesPaymentTypesResponse](docs/Model/IikoTransportPublicApiContractsPaymentTypesPaymentTypesResponse.md)
- [IikoTransportPublicApiContractsPaymentsPaymentLink](docs/Model/IikoTransportPublicApiContractsPaymentsPaymentLink.md)
- [IikoTransportPublicApiContractsPaymentsPaymentLinkStatus](docs/Model/IikoTransportPublicApiContractsPaymentsPaymentLinkStatus.md)
- [IikoTransportPublicApiContractsRemovalTypesRemovalType](docs/Model/IikoTransportPublicApiContractsRemovalTypesRemovalType.md)
- [IikoTransportPublicApiContractsRemovalTypesRemovalTypesResponse](docs/Model/IikoTransportPublicApiContractsRemovalTypesRemovalTypesResponse.md)
- [IikoTransportPublicApiContractsReservesAddOrderItemsToBanquetRequest](docs/Model/IikoTransportPublicApiContractsReservesAddOrderItemsToBanquetRequest.md)
- [IikoTransportPublicApiContractsReservesAddOrderPaymentsToBanquetRequest](docs/Model/IikoTransportPublicApiContractsReservesAddOrderPaymentsToBanquetRequest.md)
- [IikoTransportPublicApiContractsReservesCancelReserveRequest](docs/Model/IikoTransportPublicApiContractsReservesCancelReserveRequest.md)
- [IikoTransportPublicApiContractsReservesChangeBanquetOrderItemsRequest](docs/Model/IikoTransportPublicApiContractsReservesChangeBanquetOrderItemsRequest.md)
- [IikoTransportPublicApiContractsReservesChangeReserveEstimatedStartTimeRequest](docs/Model/IikoTransportPublicApiContractsReservesChangeReserveEstimatedStartTimeRequest.md)
- [IikoTransportPublicApiContractsReservesChangeReserveTablesRequest](docs/Model/IikoTransportPublicApiContractsReservesChangeReserveTablesRequest.md)
- [IikoTransportPublicApiContractsReservesColor](docs/Model/IikoTransportPublicApiContractsReservesColor.md)
- [IikoTransportPublicApiContractsReservesCreateReserveRequest](docs/Model/IikoTransportPublicApiContractsReservesCreateReserveRequest.md)
- [IikoTransportPublicApiContractsReservesFont](docs/Model/IikoTransportPublicApiContractsReservesFont.md)
- [IikoTransportPublicApiContractsReservesFontStyle](docs/Model/IikoTransportPublicApiContractsReservesFontStyle.md)
- [IikoTransportPublicApiContractsReservesGetRestaurantSectionsRequest](docs/Model/IikoTransportPublicApiContractsReservesGetRestaurantSectionsRequest.md)
- [IikoTransportPublicApiContractsReservesGetRestaurantSectionsResponse](docs/Model/IikoTransportPublicApiContractsReservesGetRestaurantSectionsResponse.md)
- [IikoTransportPublicApiContractsReservesGetRestaurantSectionsWorkloadRequest](docs/Model/IikoTransportPublicApiContractsReservesGetRestaurantSectionsWorkloadRequest.md)
- [IikoTransportPublicApiContractsReservesGetRestaurantSectionsWorkloadResponse](docs/Model/IikoTransportPublicApiContractsReservesGetRestaurantSectionsWorkloadResponse.md)
- [IikoTransportPublicApiContractsReservesGuestsInfo](docs/Model/IikoTransportPublicApiContractsReservesGuestsInfo.md)
- [IikoTransportPublicApiContractsReservesRequestReserveOrder](docs/Model/IikoTransportPublicApiContractsReservesRequestReserveOrder.md)
- [IikoTransportPublicApiContractsReservesReserve](docs/Model/IikoTransportPublicApiContractsReservesReserve.md)
- [IikoTransportPublicApiContractsReservesReserveCancelReason](docs/Model/IikoTransportPublicApiContractsReservesReserveCancelReason.md)
- [IikoTransportPublicApiContractsReservesReserveInWorkload](docs/Model/IikoTransportPublicApiContractsReservesReserveInWorkload.md)
- [IikoTransportPublicApiContractsReservesReserveInfo](docs/Model/IikoTransportPublicApiContractsReservesReserveInfo.md)
- [IikoTransportPublicApiContractsReservesReserveResponse](docs/Model/IikoTransportPublicApiContractsReservesReserveResponse.md)
- [IikoTransportPublicApiContractsReservesReserveStatus](docs/Model/IikoTransportPublicApiContractsReservesReserveStatus.md)
- [IikoTransportPublicApiContractsReservesReservesByIdRequest](docs/Model/IikoTransportPublicApiContractsReservesReservesByIdRequest.md)
- [IikoTransportPublicApiContractsReservesReservesResponse](docs/Model/IikoTransportPublicApiContractsReservesReservesResponse.md)
- [IikoTransportPublicApiContractsReservesResponseReserveOrder](docs/Model/IikoTransportPublicApiContractsReservesResponseReserveOrder.md)
- [IikoTransportPublicApiContractsReservesRestaurantSection](docs/Model/IikoTransportPublicApiContractsReservesRestaurantSection.md)
- [IikoTransportPublicApiContractsReservesRestaurantSectionEllipse](docs/Model/IikoTransportPublicApiContractsReservesRestaurantSectionEllipse.md)
- [IikoTransportPublicApiContractsReservesRestaurantSectionMark](docs/Model/IikoTransportPublicApiContractsReservesRestaurantSectionMark.md)
- [IikoTransportPublicApiContractsReservesRestaurantSectionTable](docs/Model/IikoTransportPublicApiContractsReservesRestaurantSectionTable.md)
- [IikoTransportPublicApiContractsReservesSectionSchema](docs/Model/IikoTransportPublicApiContractsReservesSectionSchema.md)
- [IikoTransportPublicApiContractsReservesTable](docs/Model/IikoTransportPublicApiContractsReservesTable.md)
- [IikoTransportPublicApiContractsStopListsAddProductsToStopListItem](docs/Model/IikoTransportPublicApiContractsStopListsAddProductsToStopListItem.md)
- [IikoTransportPublicApiContractsStopListsAddProductsToStopListRequest](docs/Model/IikoTransportPublicApiContractsStopListsAddProductsToStopListRequest.md)
- [IikoTransportPublicApiContractsStopListsCheckStopListRequest](docs/Model/IikoTransportPublicApiContractsStopListsCheckStopListRequest.md)
- [IikoTransportPublicApiContractsStopListsCheckStopListResponse](docs/Model/IikoTransportPublicApiContractsStopListsCheckStopListResponse.md)
- [IikoTransportPublicApiContractsStopListsRemoveProductsFromStopListItem](docs/Model/IikoTransportPublicApiContractsStopListsRemoveProductsFromStopListItem.md)
- [IikoTransportPublicApiContractsStopListsRemoveProductsFromStopListRequest](docs/Model/IikoTransportPublicApiContractsStopListsRemoveProductsFromStopListRequest.md)
- [IikoTransportPublicApiContractsStopListsStopListItem](docs/Model/IikoTransportPublicApiContractsStopListsStopListItem.md)
- [IikoTransportPublicApiContractsStopListsStopListsRequest](docs/Model/IikoTransportPublicApiContractsStopListsStopListsRequest.md)
- [IikoTransportPublicApiContractsStopListsStopListsResponse](docs/Model/IikoTransportPublicApiContractsStopListsStopListsResponse.md)
- [IikoTransportPublicApiContractsStopListsTerminalGroupStopList](docs/Model/IikoTransportPublicApiContractsStopListsTerminalGroupStopList.md)
- [IikoTransportPublicApiContractsStopListsTerminalGroupStopListUpdate](docs/Model/IikoTransportPublicApiContractsStopListsTerminalGroupStopListUpdate.md)
- [IikoTransportPublicApiContractsStopListsWebHookOnStopListChangeData](docs/Model/IikoTransportPublicApiContractsStopListsWebHookOnStopListChangeData.md)
- [IikoTransportPublicApiContractsTableOrdersRequestAddCustomerToTableOrderRequest](docs/Model/IikoTransportPublicApiContractsTableOrdersRequestAddCustomerToTableOrderRequest.md)
- [IikoTransportPublicApiContractsTableOrdersRequestAddItemsToTableOrderRequest](docs/Model/IikoTransportPublicApiContractsTableOrdersRequestAddItemsToTableOrderRequest.md)
- [IikoTransportPublicApiContractsTableOrdersRequestAddTableOrderItemsSettings](docs/Model/IikoTransportPublicApiContractsTableOrdersRequestAddTableOrderItemsSettings.md)
- [IikoTransportPublicApiContractsTableOrdersRequestCreateTableOrderRequest](docs/Model/IikoTransportPublicApiContractsTableOrdersRequestCreateTableOrderRequest.md)
- [IikoTransportPublicApiContractsTableOrdersRequestCreateTableOrderSettings](docs/Model/IikoTransportPublicApiContractsTableOrdersRequestCreateTableOrderSettings.md)
- [IikoTransportPublicApiContractsTableOrdersRequestGetTableOrdersByIdRequest](docs/Model/IikoTransportPublicApiContractsTableOrdersRequestGetTableOrdersByIdRequest.md)
- [IikoTransportPublicApiContractsTableOrdersRequestGetTableOrdersByTableRequest](docs/Model/IikoTransportPublicApiContractsTableOrdersRequestGetTableOrdersByTableRequest.md)
- [IikoTransportPublicApiContractsTableOrdersRequestInitTableOrderByPosOrderRequest](docs/Model/IikoTransportPublicApiContractsTableOrdersRequestInitTableOrderByPosOrderRequest.md)
- [IikoTransportPublicApiContractsTableOrdersRequestInitTableOrderRequest](docs/Model/IikoTransportPublicApiContractsTableOrdersRequestInitTableOrderRequest.md)
- [IikoTransportPublicApiContractsTableOrdersRequestTableOrder](docs/Model/IikoTransportPublicApiContractsTableOrdersRequestTableOrder.md)
- [IikoTransportPublicApiContractsTableOrdersRequestTableOrderCustomer](docs/Model/IikoTransportPublicApiContractsTableOrdersRequestTableOrderCustomer.md)
- [IikoTransportPublicApiContractsTableOrdersResponseSplitOrderBetweenCashRegisters](docs/Model/IikoTransportPublicApiContractsTableOrdersResponseSplitOrderBetweenCashRegisters.md)
- [IikoTransportPublicApiContractsTableOrdersResponseTableOrder](docs/Model/IikoTransportPublicApiContractsTableOrdersResponseTableOrder.md)
- [IikoTransportPublicApiContractsTableOrdersResponseTableOrderInfo](docs/Model/IikoTransportPublicApiContractsTableOrdersResponseTableOrderInfo.md)
- [IikoTransportPublicApiContractsTableOrdersResponseTableOrderResponse](docs/Model/IikoTransportPublicApiContractsTableOrdersResponseTableOrderResponse.md)
- [IikoTransportPublicApiContractsTableOrdersResponseTableOrdersResponse](docs/Model/IikoTransportPublicApiContractsTableOrdersResponseTableOrdersResponse.md)
- [IikoTransportPublicApiContractsTerminalsAwakeTerminalGroupsRequest](docs/Model/IikoTransportPublicApiContractsTerminalsAwakeTerminalGroupsRequest.md)
- [IikoTransportPublicApiContractsTerminalsAwakeTerminalGroupsResponse](docs/Model/IikoTransportPublicApiContractsTerminalsAwakeTerminalGroupsResponse.md)
- [IikoTransportPublicApiContractsTerminalsTerminalGroup](docs/Model/IikoTransportPublicApiContractsTerminalsTerminalGroup.md)
- [IikoTransportPublicApiContractsTerminalsTerminalGroupAliveInfo](docs/Model/IikoTransportPublicApiContractsTerminalsTerminalGroupAliveInfo.md)
- [IikoTransportPublicApiContractsTerminalsTerminalGroupsIsAliveRequest](docs/Model/IikoTransportPublicApiContractsTerminalsTerminalGroupsIsAliveRequest.md)
- [IikoTransportPublicApiContractsTerminalsTerminalGroupsIsAliveResponse](docs/Model/IikoTransportPublicApiContractsTerminalsTerminalGroupsIsAliveResponse.md)
- [IikoTransportPublicApiContractsTerminalsTerminalGroupsRequest](docs/Model/IikoTransportPublicApiContractsTerminalsTerminalGroupsRequest.md)
- [IikoTransportPublicApiContractsTerminalsTerminalGroupsResponse](docs/Model/IikoTransportPublicApiContractsTerminalsTerminalGroupsResponse.md)
- [IikoTransportPublicApiContractsTipsTypesTipsType](docs/Model/IikoTransportPublicApiContractsTipsTypesTipsType.md)
- [IikoTransportPublicApiContractsTipsTypesTipsTypesResponse](docs/Model/IikoTransportPublicApiContractsTipsTypesTipsTypesResponse.md)
- [IikoTransportPublicApiContractsWebHooksDeliveryOrderErrorWebHookEventInfo](docs/Model/IikoTransportPublicApiContractsWebHooksDeliveryOrderErrorWebHookEventInfo.md)
- [IikoTransportPublicApiContractsWebHooksGetWebHookSettingsResponse](docs/Model/IikoTransportPublicApiContractsWebHooksGetWebHookSettingsResponse.md)
- [IikoTransportPublicApiContractsWebHooksPersonalShiftWebHookEventInfo](docs/Model/IikoTransportPublicApiContractsWebHooksPersonalShiftWebHookEventInfo.md)
- [IikoTransportPublicApiContractsWebHooksReserveErrorWebHookEventInfo](docs/Model/IikoTransportPublicApiContractsWebHooksReserveErrorWebHookEventInfo.md)
- [IikoTransportPublicApiContractsWebHooksStopListUpdateWebHookEventInfo](docs/Model/IikoTransportPublicApiContractsWebHooksStopListUpdateWebHookEventInfo.md)
- [IikoTransportPublicApiContractsWebHooksTableOrderErrorWebHookEventInfo](docs/Model/IikoTransportPublicApiContractsWebHooksTableOrderErrorWebHookEventInfo.md)
- [IikoTransportPublicApiContractsWebHooksUpdateWebHookSettingsRequest](docs/Model/IikoTransportPublicApiContractsWebHooksUpdateWebHookSettingsRequest.md)
- [IikoTransportPublicApiContractsWebHooksWebHookEventType](docs/Model/IikoTransportPublicApiContractsWebHooksWebHookEventType.md)
- [IncomingInvoice](docs/Model/IncomingInvoice.md)
- [IncomingInvoiceItem](docs/Model/IncomingInvoiceItem.md)
- [IncomingInvoiceRequest](docs/Model/IncomingInvoiceRequest.md)
- [IncomingInvoiceRequestItem](docs/Model/IncomingInvoiceRequestItem.md)
- [IncomingServiceCreateItem](docs/Model/IncomingServiceCreateItem.md)
- [IncomingServiceCreateRequest](docs/Model/IncomingServiceCreateRequest.md)
- [IncomingServiceGetItem](docs/Model/IncomingServiceGetItem.md)
- [IncomingServiceGetResponse](docs/Model/IncomingServiceGetResponse.md)
- [IncomingServiceListItem](docs/Model/IncomingServiceListItem.md)
- [IncomingServiceUpdateRequest](docs/Model/IncomingServiceUpdateRequest.md)
- [InternalTransferCreateItem](docs/Model/InternalTransferCreateItem.md)
- [InternalTransferCreateRequest](docs/Model/InternalTransferCreateRequest.md)
- [InternalTransferGetItem](docs/Model/InternalTransferGetItem.md)
- [InternalTransferGetResponse](docs/Model/InternalTransferGetResponse.md)
- [InternalTransferUpdateRequest](docs/Model/InternalTransferUpdateRequest.md)
- [IntervalDto](docs/Model/IntervalDto.md)
- [IntervalDto2](docs/Model/IntervalDto2.md)
- [IntervalDto3](docs/Model/IntervalDto3.md)
- [LabelDto](docs/Model/LabelDto.md)
- [LabelDto2](docs/Model/LabelDto2.md)
- [LabelDto3](docs/Model/LabelDto3.md)
- [ListRequest](docs/Model/ListRequest.md)
- [ModifierRestrictionsDto](docs/Model/ModifierRestrictionsDto.md)
- [ModifierRestrictionsDto2](docs/Model/ModifierRestrictionsDto2.md)
- [ModifierRestrictionsDto3](docs/Model/ModifierRestrictionsDto3.md)
- [ModifierRestrictionsDto4](docs/Model/ModifierRestrictionsDto4.md)
- [ModifierRestrictionsDto5](docs/Model/ModifierRestrictionsDto5.md)
- [ModifierRestrictionsDto6](docs/Model/ModifierRestrictionsDto6.md)
- [ModifierRestrictionsDto7](docs/Model/ModifierRestrictionsDto7.md)
- [ModifierRestrictionsDto8](docs/Model/ModifierRestrictionsDto8.md)
- [NutritionInfoDto](docs/Model/NutritionInfoDto.md)
- [NutritionInfoDto2](docs/Model/NutritionInfoDto2.md)
- [NutritionInfoDto3](docs/Model/NutritionInfoDto3.md)
- [NutritionInfoDto4](docs/Model/NutritionInfoDto4.md)
- [NutritionInfoDto5](docs/Model/NutritionInfoDto5.md)
- [NutritionInfoDto6](docs/Model/NutritionInfoDto6.md)
- [NutritionInfoDto7](docs/Model/NutritionInfoDto7.md)
- [NutritionInfoDto8](docs/Model/NutritionInfoDto8.md)
- [OutgoingInvoice](docs/Model/OutgoingInvoice.md)
- [OutgoingInvoiceItem](docs/Model/OutgoingInvoiceItem.md)
- [OutgoingInvoiceRequest](docs/Model/OutgoingInvoiceRequest.md)
- [OutgoingInvoiceRequestItem](docs/Model/OutgoingInvoiceRequestItem.md)
- [OutgoingServiceCreateItem](docs/Model/OutgoingServiceCreateItem.md)
- [OutgoingServiceCreateRequest](docs/Model/OutgoingServiceCreateRequest.md)
- [OutgoingServiceGetItem](docs/Model/OutgoingServiceGetItem.md)
- [OutgoingServiceGetResponse](docs/Model/OutgoingServiceGetResponse.md)
- [OutgoingServiceUpdateRequest](docs/Model/OutgoingServiceUpdateRequest.md)
- [OverrideTaxesDto](docs/Model/OverrideTaxesDto.md)
- [OverrideTaxesDto2](docs/Model/OverrideTaxesDto2.md)
- [PayOutgoingInvoiceRequest](docs/Model/PayOutgoingInvoiceRequest.md)
- [PayRequest](docs/Model/PayRequest.md)
- [PeriodScheduleDto](docs/Model/PeriodScheduleDto.md)
- [PeriodScheduleDto2](docs/Model/PeriodScheduleDto2.md)
- [PeriodScheduleDto3](docs/Model/PeriodScheduleDto3.md)
- [PriceItem](docs/Model/PriceItem.md)
- [ProductCategoryDto](docs/Model/ProductCategoryDto.md)
- [ProductCategoryDto2](docs/Model/ProductCategoryDto2.md)
- [ProductCategoryDto3](docs/Model/ProductCategoryDto3.md)
- [ProductionDocumentCreateItem](docs/Model/ProductionDocumentCreateItem.md)
- [ProductionDocumentCreateRequest](docs/Model/ProductionDocumentCreateRequest.md)
- [ProductionDocumentGetItem](docs/Model/ProductionDocumentGetItem.md)
- [ProductionDocumentGetResponse](docs/Model/ProductionDocumentGetResponse.md)
- [ProductionDocumentUpdateRequest](docs/Model/ProductionDocumentUpdateRequest.md)
- [RetrieveExternalMenuRequestDto](docs/Model/RetrieveExternalMenuRequestDto.md)
- [ReturnedInvoiceCreateItem](docs/Model/ReturnedInvoiceCreateItem.md)
- [ReturnedInvoiceCreateRequest](docs/Model/ReturnedInvoiceCreateRequest.md)
- [ReturnedInvoiceGetItem](docs/Model/ReturnedInvoiceGetItem.md)
- [ReturnedInvoiceGetResponse](docs/Model/ReturnedInvoiceGetResponse.md)
- [ReturnedInvoiceListItem](docs/Model/ReturnedInvoiceListItem.md)
- [ReturnedInvoiceUpdateRequest](docs/Model/ReturnedInvoiceUpdateRequest.md)
- [SalesDocumentCreateItem](docs/Model/SalesDocumentCreateItem.md)
- [SalesDocumentCreateRequest](docs/Model/SalesDocumentCreateRequest.md)
- [SalesDocumentGetResponse](docs/Model/SalesDocumentGetResponse.md)
- [SalesDocumentListItem](docs/Model/SalesDocumentListItem.md)
- [SalesDocumentUpdateRequest](docs/Model/SalesDocumentUpdateRequest.md)
- [SelectedCustomerTag](docs/Model/SelectedCustomerTag.md)
- [SelectedCustomerTag2](docs/Model/SelectedCustomerTag2.md)
- [SelectedCustomerTag3](docs/Model/SelectedCustomerTag3.md)
- [SelectedCustomerTag4](docs/Model/SelectedCustomerTag4.md)
- [SelectedCustomerTag5](docs/Model/SelectedCustomerTag5.md)
- [SelectedCustomerTag6](docs/Model/SelectedCustomerTag6.md)
- [SelectedCustomerTag7](docs/Model/SelectedCustomerTag7.md)
- [SelectedCustomerTag8](docs/Model/SelectedCustomerTag8.md)
- [SetPaymentDateOutgoingRequest](docs/Model/SetPaymentDateOutgoingRequest.md)
- [SetPaymentDateOutgoingResponse](docs/Model/SetPaymentDateOutgoingResponse.md)
- [TagDto](docs/Model/TagDto.md)
- [TagDto2](docs/Model/TagDto2.md)
- [TagDto3](docs/Model/TagDto3.md)
- [TaxCategoryDto](docs/Model/TaxCategoryDto.md)
- [TaxCategoryDto2](docs/Model/TaxCategoryDto2.md)
- [TaxCategoryDto3](docs/Model/TaxCategoryDto3.md)
- [TransactionItem](docs/Model/TransactionItem.md)
- [TransactionSide](docs/Model/TransactionSide.md)
- [TransformationDocumentCreateItem](docs/Model/TransformationDocumentCreateItem.md)
- [TransformationDocumentCreateRequest](docs/Model/TransformationDocumentCreateRequest.md)
- [TransformationDocumentGetItem](docs/Model/TransformationDocumentGetItem.md)
- [TransformationDocumentGetResponse](docs/Model/TransformationDocumentGetResponse.md)
- [TransformationDocumentUpdateRequest](docs/Model/TransformationDocumentUpdateRequest.md)
- [UpdateProductBarcodesRequest](docs/Model/UpdateProductBarcodesRequest.md)
- [UpdateProductBarcodesResponse](docs/Model/UpdateProductBarcodesResponse.md)
- [WriteoffDocumentCreateRequest](docs/Model/WriteoffDocumentCreateRequest.md)
- [WriteoffDocumentGetResponse](docs/Model/WriteoffDocumentGetResponse.md)
- [WriteoffDocumentListItem](docs/Model/WriteoffDocumentListItem.md)
- [WriteoffDocumentUpdateRequest](docs/Model/WriteoffDocumentUpdateRequest.md)

## Authorization
Endpoints do not require authorization.

## Tests

To run the tests, use:

```bash
composer install
vendor/bin/phpunit
```

## Author



## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: ``
    - Generator version: `7.23.0`
- Build package: `org.openapitools.codegen.languages.PhpClientCodegen`
