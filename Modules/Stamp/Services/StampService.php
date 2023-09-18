<?php
namespace Modules\Stamp\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Core\Services\AbstractService;
use Modules\Stamp\Models\Stamp;
use \Modules\Stamp\Repositories\StampRepository;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StampService extends AbstractService
{
    public function __construct(StampRepository $stampRepository, Request $request)
    {
        parent::__construct($stampRepository, $request);
    }

    /**
     * Create a stamp
     *
     * @return Model
     */
    public function create(): Model
    {
        $stamp = parent::create($this->request->all());

        $stamp->update(['qrcode' => self::generateQrcode($stamp)]);

        return $stamp;
    }

    /**
     * Generate qrcode
     *
     * @param Stamp $stamp
     * @return string
     */
    public static function generateQrcode(Stamp $stamp) : string
    {
        $verifyLink = encrypt(route('stamp.verify', ['stamp' => $stamp->id]));

        QrCode::format('png')
        ->encoding('UTF-8')
        ->size(200)
        ->margin(2)
        ->generate($verifyLink, storage_path('app/public/qrcodes/' . $stamp->reference . '.png'));

        return "storage/qrcodes/{$stamp->reference}.png";
    }
}
