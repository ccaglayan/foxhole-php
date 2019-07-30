<?php
/**
 * Created by PhpStorm.
 * User: caglarc
 * Date: 30.07.2019
 * Time: 11:16
 */

namespace FoxHolePHP;

class Client
{
    private $url = null;
    private $endpoint = null;
    private $method = null;
    private $sendData = null;
    private $requestInfo = null;

    public function __construct($dev = false)
    {
        if($dev)
            $this->url = 'https://war-service-dev.foxholeservices.com/api';
        else
            $this->url = 'https://war-service-live.foxholeservices.com/api';
    }

    /**
     * @return array
     * @throws FoxHoleException
     */
    public function getWar()
    {
        $this->_setEndPointAndMethod('worldconquest/war','GET');

        return $this->_request();
    }

    /**
     * @return array
     * @throws FoxHoleException
     */
    public function getMaps()
    {
        $this->_setEndPointAndMethod('worldconquest/maps','GET');

        return $this->_request();
    }

    /**
     * @param string $mapName
     * @return array
     * @throws FoxHoleException
     */
    public function getMapReport($mapName = null)
    {
        if(is_null($mapName))
            throw new FoxHoleException('MapName not null');

        $this->_setEndPointAndMethod('worldconquest/warReport/'.$mapName, 'GET');

        return $this->_request();
    }

    /**
     * @param string $mapName
     * @return array
     * @throws FoxHoleException
     */
    public function getStaticMapData($mapName = null)
    {
        if(is_null($mapName))
            throw new FoxHoleException('MapName not null');

        $this->_setEndPointAndMethod('worldconquest/maps/'.$mapName.'/static', 'GET');

        return $this->_request();
    }

    /**
     * @param string $mapName
     * @return array
     * @throws FoxHoleException
     */
    public function getDynamicMapData($mapName = null)
    {
        if(is_null($mapName))
            throw new FoxHoleException('MapName not null');

        $this->_setEndPointAndMethod('worldconquest/maps/'.$mapName.'/dynamic/public', 'GET');

        return $this->_request();
    }


    /**
     * @return null
     */
    public function getRequestInfo()
    {
        return $this->requestInfo;
    }

    /**
     * @param $endpoint
     * @param $method
     * @param array $sendData
     */
    private function _setEndPointAndMethod($endpoint, $method, $sendData = array())
    {
        $this->endpoint = $endpoint;
        $this->method   = $method;
        $this->sendData = $sendData;
    }

    /**
     * @return array
     * @throws FoxHoleException
     */
    private function _request()
    {
        if(is_null($this->endpoint))
            throw new FoxHoleException('You must set Endpoint');
        if(is_null($this->method))
            throw new FoxHoleException('You must set Method');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url.'/'.$this->endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        if($this->method == 'POST'){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->sendData);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($curl);
        $this->requestInfo = curl_getinfo($curl);

        if($this->requestInfo['http_code'] != 200)
            throw new FoxHoleException('API Request Error',$this->requestInfo['http_code']);

        $output = json_decode($output, true);

        return $output;
    }

}