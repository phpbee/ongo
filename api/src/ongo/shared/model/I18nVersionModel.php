<?php

namespace ongo\shared\model;

use ongo\shared\entity\I18nVersionEntity;
use Doctrine\DBAL\Connection;

final class I18nVersionModel
{
    private $dbConn;

    public function __construct(Connection $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public function find()
    {
        $i18nVersions = array();
        $rs = $this->dbConn->executeQuery("select * from i18n_version");
        while ($row = $rs->fetch()) {
            $i18nVersions[] = self::entityFromRecord($row);
        }

        return $i18nVersions;
    }

    /**
     * @param $id
     * @return I18nVersionEntity
     * @throws InvalidI18nVersionIdException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById($id)
    {
        if (!($row = $this->dbConn->executeQuery(
            "select i.id, i.url, i.currency, i.currency_symbol, i.partner_payout_limit, p.url_name
              from i18n_version i 
              left join landingpage as p on i.rev_share_landingpage_id = p.id 
              where i.id = ?",
            array($id))->fetch())
        ) {
            throw new InvalidI18nVersionIdException($id);
        }

        return self::entityFromRecord($row);
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function query()
    {
        $versions = array();
        $rs = $this->dbConn->executeQuery(
            "select i.id, i.url, i.currency, i.currency_symbol, i.partner_payout_limit, p.url_name 
              from i18n_version i 
              left join landingpage as p on i.rev_share_landingpage_id = p.id
              where i.url like 'https%' 
            "
        );
        while ($row = $rs->fetch()) {
            $versions[] = self::entityFromRecord($row);
        }

        return $versions;
    }
    private static function entityFromRecord($row)
    {
        return new I18nVersionEntity(
            $row['id'],
            $row['url'],
            $row['currency'],
            $row['currency_symbol'],
            $row['partner_payout_limit'],
            $row['url_name']
        );
    }
}

?>