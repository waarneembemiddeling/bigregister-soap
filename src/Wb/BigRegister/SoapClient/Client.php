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

class Client extends BaseSoapClient
{
    private $cache;

    private $cacheTtl;

    public function __construct($wsdl = null, array $userOptions = array(), Cache $cache = null, $cacheTtl = 0)
    {
        $wsdl = $wsdl ? $wsdl : 'http://webservices.cibg.nl/Ribiz/OpenbaarV2.asmx?WSDL';
        $namespace = 'Wb\\BigRegister\\SoapClient\\Model\\';
        $options = array(
            'features'       => SOAP_SINGLE_ELEMENT_ARRAYS,
            'classmap'       => array(
                'ListHcpApproxRequest'                      => $namespace . 'ListHcpApproxRequest',
                'ListHcpApproxResponse3'                    => $namespace . 'ListHcpApproxResponse3',
                'Address'                                   => $namespace . 'Address',
                'ListHcpApprox3'                            => $namespace . 'ListHcpApprox3',
                'ArticleRegistrationExtApp'                 => $namespace . 'ArticleRegistrationExtApp',
                'ArrayOfArticleRegistrationExtApp'          => $namespace . 'ArrayOfArticleRegistrationExtApp',
                'SpecialismExtApp'                          => $namespace . 'SpecialismExtApp',
                'ArrayOfSpecialismExtApp'                   => $namespace . 'ArrayOfSpecialismExtApp',
                'ArrayOfListHcpApprox'                      => $namespace . 'ArrayOfListHcpApprox',
                'ArrayOfRegistrationProvisionNoteExtApp'    => $namespace . 'ArrayOfRegistrationProvisionNoteExtApp',
                'RegistrationProvisionNoteExtApp'           => $namespace . 'RegistrationProvisionNoteExtApp',
                'ArrayOfListHcpApprox3'                     => $namespace . 'ArrayOfListHcpApprox3',
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

        parent::__construct($wsdl, $options);
    }

    public function __doRequest($request, $location, $action, $version)
    {
        $id = md5($request . $location . $action . $version);
        if ($this->cache && $this->cache->contains($id)) {
            return $this->cache->fetch($id);
        }

        $response = parent::__doRequest($request, $location, $action, $version);
        if ($this->cache) {
            $this->cache->save($id, $response);
        }

        return $response;
    }
}
