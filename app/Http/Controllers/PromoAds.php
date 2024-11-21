<?php

namespace App\Http\Controllers;

use App\Model\BusinessMessage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PromoAds extends Controller
{
    private $business;

    public function __construct( \App\Model\Business $business )
    {
        $this->business = $business;
    }

    public function birthday($business_id)
    {
        $business = $this->business->find($business_id);
        $messages = BusinessMessage::where('business_id', $business_id)
            ->where('type', 'BIRTHDAY')->get();

        return view('pages.business.promo.birthday.index', compact('business', 'messages'));
    }

    public function addBirthdayMessageView($business_id)
    {
        $business = $this->business->find($business_id);

        return view('pages.business.promo.birthday.add', compact('business'));
    }

    public function addBirthdayMessage($business_id)
    {
        $business = $this->business->find($business_id);
        BusinessMessage::updateOrCreate(['type' => 'BIRTHDAY'],
            [
                'business_id'   => $business_id,
                'message'       => request('message'),
                'channel'       => request('channel'),
            ]
        );

        $business->activities()->create([
            'user_id'   => $business->user_id,
            'info'      => request()->user()->name . ' added default birthday message'
        ]);

        return redirect(route('business.settings.promotions.birthday', [$business_id]))
            ->with('message', 'Birthday message added successfully');
    }


    public function holiday($business_id)
    {
        $business = $this->business->find($business_id);
        $messages = BusinessMessage::where('business_id', $business_id)
            ->where('type', 'HOLIDAY')->get();

        return view('pages.business.promo.holiday.index', compact('business', 'messages'));
    }

    public function addHolidayMessageView($business_id)
    {
        $business = $this->business->find($business_id);

        return view('pages.business.promo.holiday.add', compact('business'));
    }

    public function addHolidayMessage($business_id)
    {
        $business = $this->business->find($business_id);
        BusinessMessage::updateOrCreate(['type' => 'HOLIDAY'],
            [
                'business_id'   => $business_id,
                'message'       => request('message'),
                'channel'       => request('channel')
            ]
        );

        $business->activities()->create([
            'user_id'   => $business->user_id,
            'info'      => request()->user()->name . ' added default holiday message'
        ]);

        return redirect(route('business.settings.promotions.holiday', [$business_id]))
            ->with('message', 'Holiday message added successfully');
    }


    public function newItemAlert($business_id)
    {
        $business = $this->business->find($business_id);
        $messages = BusinessMessage::where('business_id', $business_id)
            ->where('type', 'NEW_ITEM_ALERT')->get();

        return view('pages.business.promo.new-item-alert.index', compact('business', 'messages'));
    }

    public function addNewItemAlertView($business_id)
    {
        $business = $this->business->find($business_id);

        return view('pages.business.promo.new-item-alert.add', compact('business'));
    }

    public function addNewItemAlert($business_id)
    {
        $business = $this->business->find($business_id);
        BusinessMessage::updateOrCreate(['type' => 'NEW_ITEM_ALERT'],
            [
                'business_id'   => $business_id,
                'message'       => request('message'),
                'channel'       => request('channel')
            ]
        );

        $business->activities()->create([
            'user_id'   => $business->user_id,
            'info'      => request()->user()->name . ' added default new item alert'
        ]);

        return redirect(route('business.settings.new-item-alert', [$business_id]))
            ->with('message', 'Message alert for new item added successfully');
    }



    public function tellAFriend($business_id)
    {
        $business = $this->business->find($business_id);
        $pages = $business->promoPages;

        return view('pages.business.promo.taf.index', compact('business', 'pages'));
    }

    public function addPromoPage($business_id)
    {
        $business = $this->business->find($business_id);
        return view('pages.business.promo.taf.add', compact('business'));
    }

    public function createPromoPage($business_id)
    {
        $business = $this->business->find($business_id);
        if ( request()->has('image1') && !is_null(request('image1'))
            && request()->has('image2') && !is_null(request('image2'))
        ) {
            $image1 = request()->file('image1');
            $path1 = 'images/promopage/' . Str::random() . '.'. $image1->clientExtension();
            $img1 = Image::make($image1);
            $img1->resize(700, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::disk('public')->put($path1, $img1->stream($image1->clientExtension()));

            $image2 = request()->file('image2');
            $path2 = 'images/promopage/' . Str::random() . '.'. $image2->clientExtension();
            $img2 = Image::make($image2);
            $img2->resize(700, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::disk('public')->put($path2, $img2->stream($image2->clientExtension()));

            $business->promoPages()->create([
                'user_id'   => auth()->user()->id,
                'ref'       => Str::random(),
                'image1'    => $path1,
                'image2'    => $path2
            ]);

            return redirect(route('business.settings.promotions.tell-a-friend', [$business_id]));
        }

        return back()->withInput()->with('error', 'Product image 1 & Product image 2 are both required');
    }
}
