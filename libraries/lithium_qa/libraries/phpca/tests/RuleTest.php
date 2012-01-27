<?php
/**
 * Copyright (c) 2009 Stefan Priebsch <stefan@priebsch.de>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *   * Redistributions of source code must retain the above copyright notice,
 *     this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright notice,
 *     this list of conditions and the following disclaimer in the documentation
 *     and/or other materials provided with the distribution.
 *
 *   * Neither the name of Stefan Priebsch nor the names of contributors
 *     may be used to endorse or promote products derived from this software
 *     without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER ORCONTRIBUTORS
 * BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    PHPca
 * @author     Stefan Priebsch <stefan@priebsch.de>
 * @copyright  Stefan Priebsch <stefan@priebsch.de>. All rights reserved.
 * @license    BSD License
 */

namespace spriebsch\PHPca\Rule;

use spriebsch\PHPca\Loader;
use spriebsch\PHPca\Constants;
use spriebsch\PHPca\Tokenizer;
use spriebsch\PHPca\File;
use spriebsch\PHPca\Result;

/**
 * Tests for the Rule class. Since Rule is abstract, we test through a subclass.
 *
 * @author     Stefan Priebsch <stefan@priebsch.de>
 * @copyright  Stefan Priebsch <stefan@priebsch.de>. All rights reserved.
 */
class RuleTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        Constants::init();

        $this->file = Tokenizer::tokenize('test.php', '<php print true; ?>');
        $this->result = new Result();
        $this->result->addFile('test.php');

        $this->rule = new TestRuleSubclass();
    }

    /**
     * @covers spriebsch\PHPca\Rule\Rule::check
     * @covers spriebsch\PHPca\Rule\Rule::addViolation
     */
    public function testAddMessage()
    {
        $this->rule->check($this->file, $this->result);
        $this->assertTrue($this->result->hasViolations());
        $messages = $this->result->getViolations('test.php');
        $this->assertEquals($this->file[0], $messages[0]->getToken());
    }
}
?>