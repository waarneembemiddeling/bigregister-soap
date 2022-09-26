<?php
/*
* (c) Waarneembemiddeling.nl
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Wb\BigRegister\SoapClient;

use Doctrine\Common\Cache\Cache;
use SoapClient as BaseSoapClient;
use Wb\BigRegister\SoapClient\Exception\ConnectionException;

class Client extends BaseSoapClient
{
    private $cache;

    private $cacheTtl;

    public function __construct($wsdl = null, array $userOptions = array(), Cache $cache = null, $cacheTtl = 0, $disableErrorsInConstructor = false)
    {
        $wsdl = $wsdl ? $wsdl : 'http://webservices.cibg.nl/Ribiz/OpenbaarV4.asmx?wsdl';
        $namespace = 'Wb\\BigRegister\\SoapClient\\Model\\';
        $options = array(
            'features'       => SOAP_SINGLE_ELEMENT_ARRAYS,
            'cache_wsdl'     => WSDL_CACHE_NONE,
            'classmap'       => array(
                'ListHcpApproxRequest'                      => $namespace . 'ListHcpApproxRequest',
                'ListHcpApproxResponse4'                    => $namespace . 'ListHcpApproxResponse4',
                'Address'                                   => $namespace . 'Address',
                'ListHcpApprox4'                            => $namespace . 'ListHcpApprox4',
                'ArticleRegistrationExtApp'                 => $namespace . 'ArticleRegistrationExtApp',
                'ArrayOfArticleRegistrationExtApp'          => $namespace . 'ArrayOfArticleRegistrationExtApp',
                'SpecialismExtApp1'                         => $namespace . 'SpecialismExtApp1',
                'ArrayOfSpecialismExtApp1'                  => $namespace . 'ArrayOfSpecialismExtApp1',
                'ArrayOfListHcpApprox'                      => $namespace . 'ArrayOfListHcpApprox',
                'ArrayOfRegistrationProvisionNoteExtApp'    => $namespace . 'ArrayOfRegistrationProvisionNoteExtApp',
                'RegistrationProvisionNoteExtApp'           => $namespace . 'RegistrationProvisionNoteExtApp',
                'ArrayOfListHcpApprox4'                     => $namespace . 'ArrayOfListHcpApprox4',
                'ArrayOfMentionExtApp'                      => $namespace . 'ArrayOfMentionExtApp',
                'MentionExtApp'                             => $namespace . 'MentionExtApp',
                'ArrayOfJudgmentProvisionExtApp'            => $namespace . 'ArrayOfJudgmentProvisionExtApp',
                'JudgmentProvisionExtApp'                   => $namespace . 'JudgmentProvisionExtApp',
                'ArrayOfLimitationExtApp'                   => $namespace . 'ArrayOfLimitationExtApp',
                'LimitationExtApp'                          => $namespace . 'LimitationExtApp',
                'ArrayOfProfessionalGroup'                  => $namespace . 'ArrayOfProfessionalGroup',
                'ProfessionalGroup'                         => $namespace . 'ProfessionalGroup',
                'ArrayOfTypeOfSpecialism'                   => $namespace . 'ArrayOfTypeOfSpecialism',
                'TypeOfSpecialism'                          => $namespace . 'TypeOfSpecialism'
            ),
        );
        $options        = array_merge($options, $userOptions);
        $this->cache    = $cache;
        $this->cacheTtl = (int) $cacheTtl;

        // Disable exceptions and warnings in __construct. When using this client via a service container like the
        // Symfony2 one, instantiating the client results in a non catchable fatal when WSDL is down. With this
        // parameter you can disable it, so you can try catch the call itself.
        // Be warned you should catch SoapFault exceptions when calling the webservice.
        if ($disableErrorsInConstructor) {
            // Disable error handler for now
            $previous = set_error_handler(function() {}, E_ALL);
            try {
                parent::__construct($wsdl, $options);
            } catch (\SoapFault $e) {}
            // Restore previous error handler
            set_error_handler($previous);
        } else {
            parent::__construct($wsdl, $options);
        }
    }

    public function __call($method, $arguments)
    {
        try {
            return parent::__call($method, $arguments);
        } catch (\SoapFault $e) {
            throw new ConnectionException("Problem with connecting BIG Register", 0, $e);
        }
    }

    public function __doRequest($request, $location, $action, $version, $one_way = 0 )
    {
        $id = md5($request . $location . $action . $version);
        if ($this->cache && $this->cache->contains($id)) {
            return $this->cache->fetch($id);
        }

        $response = parent::__doRequest($request, $location, $action, $version, $one_way);

        if ($this->cache) {
            $this->cache->save($id, $response);
        }

        return $response;
    }
}
