<?php
namespace Database\Seeders;

use App\Model\Config;
use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        //Business Types
        $business_types = ['Fashion', 'Information Technology', 'Food and Beverages', 'Furniture', 'Building', 'Vehicle', 'Machinery', 'Arts and Creativity', 'Education', 'Stationery'];
        Config::updateOrCreate(['name' => 'BUSINESS_TYPES'], ['value' => json_encode($business_types)]);

        //Social Accounts
        $social_accounts = ['WHATSAPP', 'FACEBOOK', 'INSTAGRAM', 'TWITTER', 'YOUTUBE'];
        Config::updateOrCreate(['name' => 'SOCIAL_ACCOUNTS'], ['value' => json_encode($social_accounts)]);

        //unit of measurement
        $units = ['inches', 'pieces', 'cl', 'litres', 'ml', 'kilograms', 'yards', 'mg', 'meter', 'grams', 'cm', 'mm', 'tonnes', 'pound', 'ounce'];
        Config::updateOrCreate(['name' => 'UNIT_OF_MEASUREMENT'], ['value' => json_encode($units)]);

        //Channel
        $channels = ['EMAIL', 'SMS', 'WHATSAPP'];
        Config::updateOrCreate(['name' => 'CHANNELS'], ['value' => json_encode($channels)]);

        //Payment Status
        $payment_status = ['FULLY PAID', 'PART PAYMENT', 'UNPAID'];
        Config::updateOrCreate(['name' => 'PAYMENT_STATUS'], ['value' => json_encode($payment_status)]);

        //Payment Method
        $payment_methods = ['CASH', 'BANK TRANSFER', 'CHEQUE', 'CREDIT CARD', 'DISCOUNT VOUCHER'];
        Config::updateOrCreate(['name' => 'PAYMENT_METHODS'], ['value' => json_encode($payment_methods)]);

        //Purchase Expenses
        $business_expenses = ['Airtime- phone calls and data subscriptions', 'Bank charges', 'Business registration fee', 'Giveaways and freebies', 'Delivery fee outbound', 'Imelar promotion/subscription', 'Interest on loans', 'Office supplies', 'Printing, designs and stationaries', 'Professional service fee - IT maintenance, Legal, Accounting, e.t.c', 'Social media promotion', 'Stolen or damaged  item cost', 'Tax', 'Utilities- electricity, water', 'Vehicle Fuel', 'Vehicle maintenance', 'Wages and Salaries', 'Other expenses'];
        Config::updateOrCreate(['name' => 'BUSINESS_EXPENSES'], ['value' => json_encode($business_expenses)]);

        //Purchase Expenses
        $purchase_expenses = ['Transport and Delivery', 'Packaging', 'Storage and Handling', 'Agency and Brokerage Fees'];
        Config::updateOrCreate(['name' => 'PURCHASE_EXPENSES'], ['value' => json_encode($purchase_expenses)]);

        //Banks
        $banks = [
            ['name' => 'Access Bank', 'slug' => 'access-bank', 'code' => '044', 'long_code' => '044150149'],
            ['name' => 'Access Bank (Diamond)', 'slug' => 'access-bank-diamond', 'code' => '063', 'long_code' => '063150162'],
            ['name' => 'ALAT by WEMA', 'slug' => 'alat-by-wema', 'code' => '035A', 'long_code' => '035150103'],
            ['name' => 'ASO Savings and Loans', 'slug' => 'ASO Savings and Loans', 'code' => '401', 'long_code' => null],
            ['name' => 'Citibank Nigeria', 'slug' => 'citibank-nigeria', 'code' => '023', 'long_code' => '023150005'],
            ['name' => 'Ecobank Nigeria', 'slug' => 'ecobank-nigeria', 'code' => '050', 'long_code' => 'ecobank-nigeria'],
            ['name' => 'Ekondo Microfinance Bank', 'slug' => 'ekondo-microfinance-bank', 'code' => '562', 'long_code' => null],
            ['name' => 'Enterprise Bank', 'slug' => 'enterprise-bank', 'code' => '084', 'long_code' => '084150015'],
            ['name' => 'Fidelity Bank', 'slug' => 'fidelity-bank', 'code' => '070', 'long_code' => '070150003'],
            ['name' => 'First Bank of Nigeria', 'slug' => 'first-bank-of-nigeria', 'code' => '011', 'long_code' => '011151003'],
            ['name' => 'First City Monument Bank', 'slug' => 'first-city-monument-bank', 'code' => '214', 'long_code' => '214150018'],
            ['name' => 'Guaranty Trust Bank', 'slug' => 'guaranty-trust-bank', 'code' => '058', 'long_code' => '058152036'],
            ['name' => 'Heritage Bank', 'slug' => 'heritage-bank', 'code' => '030', 'long_code' => '030159992'],
            ['name' => 'Jaiz Bank', 'slug' => 'jaiz-bank', 'code' => '301', 'long_code' => '301080020'],
            ['name' => 'Keystone Bank', 'slug' => 'keystone-bank', 'code' => '082', 'long_code' => '082150017'],
            ['name' => 'MainStreet Bank', 'slug' => 'mainstreet-bank', 'code' => '014', 'long_code' => '014150331'],
            ['name' => 'Parallex Bank', 'slug' => 'parallex-bank', 'code' => '526', 'long_code' => null],
            ['name' => 'Polaris Bank', 'slug' => 'polaris-bank', 'code' => '076', 'long_code' => '076151006'],
            ['name' => 'Providus Bank', 'slug' => 'providus-bank', 'code' => '101', 'long_code' => null],
            ['name' => 'Stanbic IBTC Bank', 'slug' => 'stanbic-ibtc-bank', 'code' => '221', 'long_code' => '221159522'],
            ['name' => 'Standard Chartered Bank', 'slug' => 'standard-chartered-bank', 'code' => '068', 'long_code' => '068150015'],
            ['name' => 'Sterling Bank', 'slug' => 'sterling-bank', 'code' => '232', 'long_code' => '232150016'],
            ['name' => 'Suntrust Bank', 'slug' => 'suntrust-bank', 'code' => '100', 'long_code' => null],
            ['name' => 'Union Bank of Nigeria', 'slug' => 'union-bank-of-nigeria', 'code' => '032', 'long_code' => '032080474'],
            ['name' => 'United Bank For Africa', 'slug' => 'united-bank-for-africa', 'code' => '033', 'long_code' => '033153513'],
            ['name' => 'Unity Bank', 'slug' => 'unity-bank', 'code' => '215', 'long_code' => '215154097'],
            ['name' => 'Wema Bank', 'slug' => 'wema-bank', 'code' => '035', 'long_code' => '035150103'],
            ['name' => 'Zenith Bank', 'slug' => 'zenith-bank', 'code' => '057', 'long_code' => '057150013'],
        ];
        Config::updateOrCreate(['name' => 'BANKS'], ['value' => json_encode($banks)]);
    }
}
