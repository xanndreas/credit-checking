<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DealerInformation extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'dealer_informations';

    protected $appends = [
        'id_photos',
    ];

    public const DOWN_PAYMENT_SELECT = [
        '15' => '15%',
        '25' => '25%',
        '30' => '30%',
        '35' => '35%',
        'Other' => 'Other',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'dealer_id',
        'sales_name',
        'product_id',
        'brand_id',
        'models',
        'number_of_units',
        'otr',
        'debt_principal',
        'insurance_id',
        'down_payment',
        'tenors_id',
        'addm_addb',
        'effective_rates',
        'debtor_phone',
        'remarks',
        'debtor_information_id',
        'dealer_text',
        'brand_text',
        'down_payment_text',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function dealer()
    {
        return $this->belongsTo(Dealer::class, 'dealer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }

    public function tenors()
    {
        return $this->belongsTo(Tenor::class, 'tenors_id');
    }

    public function getIdPhotosAttribute()
    {
        $files = $this->getMedia('id_photos');
        $files->each(function ($item) {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview = $item->getUrl('preview');
        });

        return $files;
    }

    public function debtor_information()
    {
        return $this->belongsTo(DebtorInformation::class, 'debtor_information_id');
    }
}
