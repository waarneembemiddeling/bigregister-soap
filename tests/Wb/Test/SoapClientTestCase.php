<?php
/*
* (c) Waarneembemiddeling.nl
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Wb\Test;

use \InvalidArgumentException;

class SoapClientTestCase extends \PHPUnit_Framework_TestCase
{
    public function getMockSoapClient($search)
    {
        $mockPath = __DIR__ .'/../../mock';
        $mockFile = sprintf('%s/%s.xml', $mockPath, $search);
        if (is_file($mockFile) && is_readable($mockFile)) {
            $stub = $this->getMock('Wb\BigRegister\SoapClient\Client', array(
                '__doRequest'
            ));
            $stub->expects($this->any())
                ->method('__doRequest')
                ->will($this->returnValue(file_get_contents($mockFile)));

            return $stub;
        }

        throw new InvalidArgumentException(sprintf('Mock "%s" could not be found', $mockFile));
    }
} 
