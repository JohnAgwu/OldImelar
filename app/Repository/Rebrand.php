<?php
/**
 * Created by Canaan Etai.
 * Date: 8/1/19
 * Time: 9:59 AM
 */

namespace App\Repository;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Rebrand
{
    public static $path = '/u/';

    public static function brand($url)
    {
        $brand = Rebrand::newBrand();
        $rebrand = \App\Rebrand::create([
            'url'   => $url,
            'brand' => $brand
        ]);

        $rebrand->brand = Rebrand::$path . $rebrand->brand;
        return $rebrand;
    }

    public static function newBrand()
    {
        $brand = bin2hex(random_bytes(4));
        if ( \App\Rebrand::where('brand', $brand)->count() > 0 ) {
            return Rebrand::newBrand();
        }

        return $brand;
    }

    public static function process($hash)
    {
        $brand = \App\Rebrand::where('brand', $hash);
        if ( $brand->count() > 0 ) {
            return redirect($brand->first()->url);
        }

        throw new NotFoundHttpException();
    }
}