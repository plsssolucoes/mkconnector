<?php
/**
 * Created by PhpStorm.
 * User: joaoh
 * Date: 05/03/18
 * Time: 10:17
 */

namespace PLSS\MKConnector;

class MKConnectorFacebookLogin {

    private $mkconnection;

    public function __construct() {
        $this->mkconnection = MKConnector::connect();
    }

    /**
     * Faz chamada para o MK Adicionando ip na whitelist, permitindo assim que o usuario
     * acesse o facebook por 5 minutos e consequentemente faça o login.
     *
     * @param $ip
     */
    public function addUserToLoginMKWhitelist($ip) {
        $setMKRequest = MKConnector::setRequest('/ip firewall address-list add');
        $this->mkconnection->sendSync($setMKRequest
            ->setArgument('address', $ip)
            ->setArgument('list', config('mk-fbuser.mk-login-whitelist'))
            ->setArgument('timeout', config('mk-fbuser.mk-login-timeout'))
        );

        $this->waitToAddIP($this->mkconnection, $ip);
    }

    /**
     * Aguarda MK adicionar o ip na Whitelist para redirecionar o usuario.
     *
     * @param $ip
     */
    private function waitToAddIP($mkconnection, $ip) {
        $setMKRequest = MKConnector::setRequest('/ip firewall address-list print');
        $setMKRequest->setQuery(
            MKQuery::where('address', $ip)
        );

        do {
            $ip_response = $mkconnection->sendSync($setMKRequest)->getProperty('address');
        } while ($ip_response != $ip);
    }

    public function addUserToMKWhitelist($ip) {
        $this->mkconnection = MKConnector::connect();

        $setMKRequest = MKConnector::setRequest('/ip firewall address-list add');
        $this->mkconnection->sendSync($setMKRequest
            ->setArgument('address', $ip)
            ->setArgument('list', config('mk-fbuser.mk-whitelist'))
            ->setArgument('timeout', config('mk-fbuser.mk-timeout'))
        );

        $this->getMacAddress($ip);
    }

    /**
     * Busca MAC Address na tabela ARP do MK
     *
     * @return mixed
     */
    private function getMacAddress($ip) {
        $setMKRequest = MKConnector::setRequest('/ip arp print .proplist=mac-address');
        $setMKRequest->setQuery(
            MKQuery::where('address', $ip)
        );

        $mac = $this->mkconnection->sendSync($setMKRequest)->getProperty('mac-address');

        $this->logFacebookAccess($ip, $mac);
    }

    /**
     * Adiciona linha de log conexao com facebook
     *
     * @param $mac
     * @return mixed
     */
    private function logFacebookAccess($ip, $mac) {
        $log = MKConnector::setRequest('/log info');

        $logMessage = 'FACEBOOK_LOGIN => IP_ADDRESS '.$ip.' MAC_ADDRESS '.$mac.' FACEBOOK_ID '.$this->fbUser->id;

        $this->mkconnection->sendSync($log
            ->setArgument('message', $logMessage)
        );
    }


}