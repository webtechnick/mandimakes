<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'name_line','street','street_2','city','state','zipcode','country'
    ];

    /**
     * Create an addres from stripe data
     * @param  [type] $data [description]
     * @param  string $type [description]
     * @return [type]       [description]
     */
    public static function createFromStripe($data, $type = 'billing')
    {
        $mapped = self::mapStripeToFields($data);

        // Check if we have this address already
        $address = self::where($mapped[$type])->first();
        if ($address) {
            return $address;
        }

        // We don't have this address, create it.
        $address = self::create($mapped[$type]);
        return $address;
    }

    public function findByStripe($data)
    {
    }

    /**
     * Map stripe fields to internal data fields
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    protected static function mapStripeToFields($data)
    {
        $retval = [
            'billing' => [
                'name_line' => $data['stripeBillingName'],
                'street' => $data['stripeBillingAddressLine1'],
                'street_2' => '',
                'city' => $data['stripeBillingAddressCity'],
                'state' => $data['stripeBillingAddressState'],
                'zipcode' => $data['stripeBillingAddressZip'],
                'country' => $data['stripeBillingAddressCountryCode'],
            ],
            'shipping' => [
                'name_line' => $data['stripeShippingName'],
                'street' => $data['stripeShippingAddressLine1'],
                'street_2' => '',
                'city' => $data['stripeShippingAddressCity'],
                'state' => $data['stripeShippingAddressState'],
                'zipcode' => $data['stripeShippingAddressZip'],
                'country' => $data['stripeShippingAddressCountryCode'],
            ]
        ];

        return $retval;
    }
}
