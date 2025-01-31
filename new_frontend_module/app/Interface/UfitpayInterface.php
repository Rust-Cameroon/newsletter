<?php

interface UfitpayInterface
{
    /**
     * Get Exchange Rate
     *
     * @param  string  $currency
     *                            - $currency (string, required): This is the currency to get exchange rate in naira for. Supported values are USD and EUR only
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExchangeRate(string $currency);

    /**
     * Create a new Card Holder.
     *
     * @param  array  $data
     *                       An array containing the following keys:
     *                       - 'first_name' (string, required): The first name of the card holder.
     *                       - 'last_name' (string, required): The last name of the card holder.
     *                       - 'email' (string, required): This is the card holder's email address (This will be used for OTP delivery is supported)
     *                       - 'phone' (string, required): This is the card holder's mobile phone number (This will be used for OTP delivery is supported)
     *                       - 'kyc_method' (string, required): This is the prefered method to use for the card-holder's identity verification. Supported values are SELFIE_IMAGE (Nigeria only), NIGERIAN_NIN, NIGERIAN_INTERNATIONAL_PASSPORT, NIGERIAN_PVC, NIGERIAN_DRIVERS_LICENSE, KENYAN_PASSPORT, KENYAN_NATIONAL_ID, BRAZIL_PASSPORT, UNITED_STATES_INTERNATIONAL_PASSPORT, UNITED_STATES_RESIDENCE_CARD, UNITED_KINGDOM_INTERNATIONAL_PASSPORT, ALGERIA_PASSPORT, GHANIAN_INTERNATIONAL_PASSPORT, IVORYCOAST_PASSPORT, SOUTHAFRICAN_PASSPORT, MOROCCO_PASSPORT, NETHERLAND_PASSPORT
     *                       - 'bvn' (string, required only if kyc_method is either "NIGERIAN_DRIVERS_LICENSE", "NIGERIAN_PVC", "NIGERIAN_INTERNATIONAL_PASSPORT", "NIGERIAN_NIN" or "SELFIE_IMAGE"):  This is the card holder's BVN
     *                       - 'selfie_image' (string, required only if kyc_method is SELFIE_IMAGE): This is the remote URL to the card holder's Pasport-sized Photo or selfie clearly showing the card holder's face. The image shoiuld be captured with a camera under bright condition. Only PNG and JPG images are allowed
     *                       - 'id_image' (string, required for every other kyc_method except for SELFIE_IMAGE): This is the remote image URL to the card-holder's ID card. Only PNG and JPG images are allowed
     *                       - 'back_id_image' (string, required only if kyc_method is either KENYAN_NATIONAL_ID, UNITED_STATES_RESIDENCE_CARD): This is the remote image URL to the back of the card-holder's ID card. Only PNG and JPG images are allowed
     *                       - 'id_number' (string, required for every other kyc_method except for SELFIE_IMAG): This is the card holder's ID Number.
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCardHolder(array $data);

    /**
     * Delete a Card Holder.
     *
     * @param  string  $cardHolderId
     *                                - $cardHolderId (string, required): This is the card_holder_id of the card holder to be deleted
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCardHolder(string $cardHolderId);

    /**
     * Create Virtual Card.
     * Note: You are now required to create a card holder for the user first (if you haven't done so already), then pass the card holder's ID under card_holder_id
     *
     * @param  array  $data
     *                       An array containing the following keys:
     *                       - 'card_brand'  (string, required): This is the brand of virtual card you wish to create. Supported values are "mastercard", "visa", "visa3D" and "verve" only
     *                       - 'card_currency'  (string, required): This is the currency for the new card. Supported values are "NGN" and "USD" only
     *                       - 'amount'  (string, optional): This is the amount to be prefunded in the card's currency (eg. amount in NGN for naira cards or amount in USD for dollar cards). This should be above 2000 for NGN and 5 for USD cards
     *                       - 'funding_currency'  (string, required if amount is set): This is the currency code of the wallet to be billed for the transaction. Supported values are "NGN" and "USD" only
     *                       - 'card_holder_id'  (string, required): Pass a valid card holder's card_holder_id here to create a card under the card holder's profile
     *                       - 'callback_url'  (string, optional): This is a custom URL you would like us to send all event related to this card to. Refer to Webhook Documentation for more
     * @return \Illuminate\Http\JsonResponse
     */
    public function createVirtualCard(array $data);

    /**
     * List Virtual Cards.
     *
     * @param  string  $currency
     *                            - $currency (string, optional): Pass a valid currency code here to limit the returned records to cards issued in this currency. Supported values are "NGN", "USD" and "EUR"
     * @return \Illuminate\Http\JsonResponse
     */
    public function listVirtualCard(?string $currency = null);

    /**
     * Get Virtual Card Details.
     *
     * @param  string  $id
     *                      - $id (string, required): This is the unique ID of the card to get details for
     * @return \Illuminate\Http\JsonResponse
     */
    public function cardDetails(string $id);

    /**
     * Fund Virtual Card.
     *
     * @param  array  $data
     *                       An array containing the following keys:
     *                       - 'id' (string, required): This is the unique ID of the card to be funded
     *                       - 'amount' (string, required): This is the amount to be funded in the card's currency (eg. amount in NGN for naira cards or amount in USD for dollar cards)
     *                       - 'funding_currency' (string, required): This is the currency code of the wallet to be billed for the transaction. Supported values are "NGN" and "USD" only
     * @return \Illuminate\Http\JsonResponse
     */
    public function fund(array $data);

    /**
     * Withdraw Funds from Virtual Card.
     *
     * @param  array  $data
     *                       An array containing the following keys:
     *                       - 'id' (string, required): This is the unique ID of the card to be withdrawn from
     *                       - 'amount' (string, required): This is the amount to be withdrawn in the card's currency (eg. amount in NGN for naira cards or amount in USD for dollar cards)
     * @return \Illuminate\Http\JsonResponse
     */
    public function withdraw(array $data);

    /**
     * Block / Unblock Virtual Card.
     *
     * @param  array  $data
     *                       An array containing the following keys:
     *                       - 'id' (string, required): This is the unique ID of the card to update
     *                       - 'status' (string, required): This is the new status to set on the card. Supported values are "active" and "inactive" only
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(array $data);

    /**
     * Update Virtual Card
     *
     * @param  string  $id,  string $callback
     *                       - id (string, required): This is the unique ID of the card to update
     *                       - callback (string, optional): Pass a valid URL here to update the webhook URL for the card
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(string $id, string $callback);

    /**
     * Fetch Card Transactions
     *
     * @param  string  $id,  string $limit_datetime
     *                       - id (string, required): This is the unique ID of the card to return transactions for
     *                       - limit_datetime (string, optional): Pass a value here to limit the returned records to those that occured after this date and time. Supported data format is "YYYY-MM-DD HH:MM:SS" (eg. 2022-02-23 11:54:00)
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchTransaction(string $id, string $limit_datetime);

    /**
     * Change Card PIN
     *
     * @param  string  $id
     *                      - id (string, required): This is the unique ID of the card to change PIN for
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePin(string $id);

    /**
     * Delete / Terminate Virtual Card
     *
     * @param  string  $id
     *                      - id (string, required): This is the unique ID of the card to terminate
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCard(string $id);
}
