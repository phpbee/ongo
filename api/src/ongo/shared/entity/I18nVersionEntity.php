<?php

namespace ongo\shared\entity;

use ongo\shared\model\I18nVersionModel;
use Doctrine\DBAL\Connection;

final class I18nVersionEntity extends SerializableEntity
{
    /** @var  int */
    private $id;
    /** @var  string */
    private $url;
    /** @var  string */
    private $currency;
    /** @var  string */
    private $currency_symbol;
    /** @var  string */
    private $partner_payout_limit;
    /** @var  string */
    private $landing_page_url_name;

    /**
     * I18nVersionEntity constructor.
     * @param int $id
     * @param string $url
     * @param string $currency
     * @param string $currency_symbol
     * @param string $partner_payout_limit
     * @param string $landing_page_url_name
     */
    public function __construct($id, $url, $currency, $currency_symbol, $partner_payout_limit, $landing_page_url_name)
    {
        $this->id = $id;
        $this->url = $url;
        $this->currency = $currency;
        $this->currency_symbol = $currency_symbol;
        $this->partner_payout_limit = $partner_payout_limit;
        $this->landing_page_url_name = $landing_page_url_name;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return mixed
     */
    public function getPartnerPayoutLimit()
    {
        return $this->partner_payout_limit;
    }

    public static function unserialize(array $array, Connection $dbConn)
    {
        parent::validate($array, array("id"));
        $model = new I18nVersionModel($dbConn);
        return $model->findById($array["id"]);
    }

    /**
     * @param Connection $dbConn
     * @param bool $deep
     * @return array
     */
    public function serialize(Connection $dbConn, $deep = true)
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'currency' => $this->currency,
            'currency_symbol' => $this->currency_symbol,
            'partner_payout_limit' => $this->partner_payout_limit,
            'landing_page_url_name' => $this->landing_page_url_name,
        ];
    }
}
?>