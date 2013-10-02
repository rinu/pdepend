<?php
/**
 * This file is part of PDepend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2013, Manuel Pichler <mapi@pdepend.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @copyright 2008-2013 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
  * @since     1.0.0
 */

namespace PHP\Depend\Source\AST;

use PHP\Depend\AbstractTest;

/**
 * Test case for the {@link \PHP\Depend\Source\AST\ASTClassOrInterfaceReferenceIterator}
 * class.
 *
 * @copyright 2008-2013 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @since 1.0.0
 *
 * @covers \PHP\Depend\Source\AST\ASTClassOrInterfaceReferenceIterator
 * @group unittest
 */
class ASTClassOrInterfaceReferenceIteratorTest extends AbstractTest
{
    /**
     * testIteratorReturnsExpectedClasses
     *
     * @return void
     */
    public function testIteratorReturnsExpectedClasses()
    {
        $class1 = new ASTClass('c1');
        $class1->setUuid(md5(23));

        $class2 = new ASTClass('c2');
        $class2->setUuid(md5(42));

        $reference1 = $this->getMockBuilder(\PHP\Depend\Source\AST\ASTSelfReference::CLAZZ)
            ->disableOriginalConstructor()
            ->getMock();
        $reference1->expects($this->once())
            ->method('getType')
            ->will($this->returnValue($class1));

        $reference2 = $this->getMockBuilder(\PHP\Depend\Source\AST\ASTSelfReference::CLAZZ)
            ->disableOriginalConstructor()
            ->getMock();
        $reference2->expects($this->once())
            ->method('getType')
            ->will($this->returnValue($class2));

        $references = array($reference1, $reference2);

        $refs  = new ASTClassOrInterfaceReferenceIterator($references);
        $types = array();
        foreach ($refs as $type) {
            $types[] = $type->getUuid();
        }

        $this->assertEquals(array($class1->getUuid(), $class2->getUuid()), $types);
    }

    /**
     * testIteratorReturnsSameClassOnlyOnce
     *
     * @return void
     */
    public function testIteratorReturnsSameClassOnlyOnce()
    {
        $class1 = new ASTClass('c1');
        $class1->setUuid(md5(23));

        $class2 = new ASTClass('c2');
        $class2->setUuid(md5(23));

        $reference1 = $this->getMockBuilder(\PHP\Depend\Source\AST\ASTSelfReference::CLAZZ)
            ->disableOriginalConstructor()
            ->getMock();
        $reference1->expects($this->once())
            ->method('getType')
            ->will($this->returnValue($class1));

        $reference2 = $this->getMockBuilder(\PHP\Depend\Source\AST\ASTSelfReference::CLAZZ)
            ->disableOriginalConstructor()
            ->getMock();
        $reference2->expects($this->once())
            ->method('getType')
            ->will($this->returnValue($class2));

        $references = array($reference1, $reference2);

        $refs  = new ASTClassOrInterfaceReferenceIterator($references);
        $types = array();
        foreach ($refs as $type) {
            $types[] = $type->getUuid();
        }

        $this->assertEquals(array($class1->getUuid()), $types);
    }
}